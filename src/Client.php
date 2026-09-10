<?php

namespace MambuSRL\Spoki;

/**
 * Shared HTTP client for all Spoki API resources.
 *
 * @example $client = new Client((string) getenv('SPOKI_API_KEY'));
 */
class Client
{
    private ?\Closure $transport = null;
    private int $timeout = 30;
    private ?string $apikey = null;
    private string $apiBaseUrl = 'https://api.spoki.com';

    /**
     * Create a Spoki API client with an optional base URL, timeout and test transport.
     *
     * The default origin is https://api.spoki.com. All network calls use HTTPS.
     * The injected transport receives (method, url, headers, body, timeout) and returns
     * ['status' => int, 'body' => string, 'headers' => array<string, string>].
     * Response header names supplied by an injected transport should be lowercase.
     *
     * @param string $apikey Account API key; an empty string is allowed only for unauthenticated automation starts.
     * @param string|null $apiBaseUrl HTTPS origin without a path; null or blank uses https://api.spoki.com.
     * @param int $timeout Positive total request timeout in seconds; default 30.
    * @param (callable(string, string, list<string>, string|null, int): array{status: int, body: string, headers?: array<string, string>})|null $transport Optional injected transport; null uses cURL.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example new Client((string) getenv('SPOKI_API_KEY'));
     */
    public function __construct(string $apikey = '', ?string $apiBaseUrl = null, int $timeout = 30, ?callable $transport = null) {
        $this->setApiKey($apikey);
        if ($timeout < 1) {
            throw new \InvalidArgumentException('The timeout must be positive.');
        }
        $this->timeout = $timeout;
        $this->transport = $transport === null ? null : \Closure::fromCallable($transport);
        if (is_string($apiBaseUrl) && trim($apiBaseUrl) !== "") {
            $this->setApiBaseUrl($apiBaseUrl);
        }
    }

    /**
     * Set an HTTPS origin for API requests, without a path, query or credentials.
     *
    * @param string $apiBaseUrl Non-empty HTTPS origin, e.g. https://api.spoki.com; trailing slashes are removed.
    * @throws \InvalidArgumentException URL is not an HTTPS origin or contains disallowed URL components.
     * @example $this->setApiBaseUrl('https://api.spoki.com');
     */
    private function setApiBaseUrl(string $apiBaseUrl): void {
        $apiBaseUrl = rtrim($apiBaseUrl, '/');
        $url = parse_url($apiBaseUrl);
        if (!$url || ($url['scheme'] ?? '') !== 'https' || empty($url['host']) ||
            isset($url['user']) || isset($url['pass']) || isset($url['query']) ||
            isset($url['fragment']) || !empty($url['path'])) {
            throw new \InvalidArgumentException('The base URL must be an HTTPS origin without path or credentials.');
        }
        $this->apiBaseUrl = $apiBaseUrl;
    }

    /**
     * Replace the account API key used by subsequent authenticated requests.
     *
     * @param string $apikey Account API key; an empty string is allowed only for unauthenticated automation starts.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $spoki->setApiKey((string) getenv('SPOKI_API_KEY'));
     */
    public function setApiKey(string $apikey): void {
        if (strpbrk($apikey, "\r\n") !== false) {
            throw new \InvalidArgumentException('Invalid API key.');
        }
        $this->apikey = $apikey;
    }

    /**
     * Return the configured API key; treat the returned value as a secret.
     *
     * The constructor normally initializes this value to a string, including an empty string.
     *
     * @return null|string Configured API key; never log this value.
     * @example $configured = $spoki->getApiKey();
     */
    public function getApiKey(): null|string {
        return $this->apikey;
    }

    /**
     * Send a REST request and return the original JSON response string.
     *
     * No implicit retries or redirects are performed. GET and DELETE normally use a null body.
     * Associative arrays become JSON objects; sequential arrays become JSON lists.
     * An empty array becomes {}, except on contacts/sync_all/, where it remains [].
     *
     * @param string $method HTTP verb: GET, POST, PATCH, PUT or DELETE.
     * @param string $path Relative API path, e.g. /api/1/contacts/; never an absolute URL.
     * @param array<array-key, mixed>|null $data Endpoint JSON body; null omits the body.
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @param bool $authenticated Whether to send X-Spoki-Api-Key; default true.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $spoki->request('GET', '/api/1/contacts/', null, ['page' => 1]);
     */
    public function request(string $method, string $path, ?array $data = null, array $query = [], bool $authenticated = true): string
    {
        $method = strtoupper($method);
        if (!in_array($method, ['GET', 'POST', 'PATCH', 'PUT', 'DELETE'], true)) {
            throw new \InvalidArgumentException('Unsupported HTTP method.');
        }
        if (!preg_match('~^/(api/1/|wh/ap/)[A-Za-z0-9_%/.-]*$~D', $path) ||
            preg_match('~(?:^|/)\.{1,2}(?:/|$)~', rawurldecode($path))) {
            throw new \InvalidArgumentException('Invalid API path.');
        }
        $headers = ['Accept: application/json'];
        if ($authenticated) {
            if ($this->apikey === null || trim($this->apikey) === '') {
                throw new \LogicException('An API key is required for this operation.');
            }
            $headers[] = 'X-Spoki-Api-Key: ' . $this->apikey;
        }
        $body = null;
        if ($data !== null) {
            $body = json_encode($data === [] && $path !== '/api/1/contacts/sync_all/' ? new \stdClass() : $data, JSON_THROW_ON_ERROR);
            $headers[] = 'Content-Type: application/json';
        }
        $url = $this->apiBaseUrl . $path;
        if ($query !== []) {
            $url .= '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
        }
        $response = $this->transport !== null
            ? ($this->transport)($method, $url, $headers, $body, $this->timeout)
            : $this->execute($method, $url, $headers, $body);
        $status = $response['status'];
        $responseBody = $response['body'];
        if ($status < 200 || $status >= 300) {
            throw new SpokiException('Spoki API request failed (HTTP ' . $status . ').', $status, $responseBody, $response['headers'] ?? []);
        }
        if ($responseBody !== '') {
            try {
                json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $exception) {
                throw new SpokiException('Spoki returned invalid JSON.', $status, $responseBody, $response['headers'] ?? [], $exception);
            }
        }
        return $responseBody;
    }

    /**
     * Send a REST request and decode its JSON response into PHP values.
     *
     * Uses the same authentication, serialization, timeout and error behavior as request().
     *
     * @param string $method HTTP verb: GET, POST, PATCH, PUT or DELETE.
     * @param string $path Relative API path, e.g. /api/1/contacts/; never an absolute URL.
     * @param array<array-key, mixed>|null $data Endpoint JSON body; null omits the body.
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @param bool $authenticated Whether to send X-Spoki-Api-Key; default true.
     * @return mixed Decoded associative arrays, lists or scalars; null for an empty response.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $contacts = $spoki->requestJson('GET', '/api/1/contacts/', query: ['page' => 1]);
     */
    public function requestJson(string $method, string $path, ?array $data = null, array $query = [], bool $authenticated = true): mixed
    {
        $response = $this->request($method, $path, $data, $query, $authenticated);
        return $response === '' ? null : json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Execute the internal HTTPS cURL transport with TLS verification and bounded timeouts.
     *
     * Internal method: request() validates the returned HTTP status and JSON body.
     * The handle is closed on success and failure. No automatic retry is performed.
     *
     * @param string $method HTTP verb: GET, POST, PATCH, PUT or DELETE.
     * @param string $url Validated absolute HTTPS URL with an already-encoded query string.
     * @param list<string> $headers HTTP headers in 'Name: value' format.
     * @param string|null $body Already-encoded JSON body, or null for no body.
     * @return array{status: int, body: string, headers: array<string, string>} Raw HTTP response with lowercase header names.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @example $response = $this->execute('GET', $url, ['Accept: application/json'], null);
     */
    private function execute(string $method, string $url, array $headers, ?string $body): array
    {
        $curl = curl_init();
        if ($curl === false) {
            throw new SpokiException('Unable to initialize cURL.');
        }
        $responseHeaders = [];
        try {
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_CONNECTTIMEOUT => min(10, $this->timeout),
                CURLOPT_TIMEOUT => $this->timeout,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_HEADERFUNCTION => static function ($handle, string $line) use (&$responseHeaders): int {
                    if (str_contains($line, ':')) {
                        [$name, $value] = explode(':', $line, 2);
                        $responseHeaders[strtolower(trim($name))] = trim($value);
                    }
                    return strlen($line);
                },
            ]);
            if ($body !== null) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            }
            $response = curl_exec($curl);
            if ($response === false) {
                throw new SpokiException('Spoki transport failed (cURL ' . curl_errno($curl) . ').');
            }
            return ['status' => (int) curl_getinfo($curl, CURLINFO_HTTP_CODE), 'body' => $response, 'headers' => $responseHeaders];
        } finally {
            curl_close($curl);
        }
    }
}
