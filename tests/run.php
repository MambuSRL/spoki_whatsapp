<?php

namespace MambuSRL\Spoki {
    final class CurlFixture
    {
        public static array $options = [];
        public static string|false $body = '{}';
        public static int $status = 200;
        public static int $closed = 0;
        public static bool $initializationFails = false;
    }

    function curl_init(): object|false
    {
        CurlFixture::$options = [];
        return CurlFixture::$initializationFails ? false : new \stdClass();
    }

    function curl_setopt_array(object $handle, array $options): bool
    {
        CurlFixture::$options = $options;
        return true;
    }

    function curl_setopt(object $handle, int $option, mixed $value): bool
    {
        CurlFixture::$options[$option] = $value;
        return true;
    }

    function curl_exec(object $handle): string|false
    {
        (CurlFixture::$options[CURLOPT_HEADERFUNCTION])($handle, "Retry-After: 60\r\n");
        return CurlFixture::$body;
    }

    function curl_getinfo(object $handle, int $option): int
    {
        return CurlFixture::$status;
    }

    function curl_errno(object $handle): int
    {
        return 28;
    }

    function curl_close(object $handle): void
    {
        CurlFixture::$closed++;
    }
}

namespace {
require __DIR__ . '/../autoload.php';

use MambuSRL\Spoki\Spoki;
use MambuSRL\Spoki\SpokiException;
use MambuSRL\Spoki\CurlFixture;

$checks = 0;
function check(bool $condition, string $message): void
{
    global $checks;
    $checks++;
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function expectException(callable $operation, string $class): Throwable
{
    try {
        $operation();
    } catch (Throwable $exception) {
        check($exception instanceof $class, 'Unexpected exception: ' . get_class($exception));
        return $exception;
    }
    throw new RuntimeException('Expected exception: ' . $class);
}

$calls = [];
$response = ['status' => 200, 'body' => '{"ok":true}', 'headers' => []];
$transport = static function (...$arguments) use (&$calls, &$response): array {
    $calls[] = $arguments;
    return $response;
};
$client = new Spoki('test-key', null, 17, $transport);
$reference = json_decode(file_get_contents(__DIR__ . '/fixtures/endpoints.json'), true, 512, JSON_THROW_ON_ERROR);
$expected = [];
foreach ($reference['operations'] as $operation) {
    $path = preg_replace('/\{\{(?:id|id_channel|uuid|phone)\}\}|:identifier/', '7', $operation['path']);
    $expected[$operation['method'] . ' ' . $path] = true;
}
$actual = [];
$methods = [];
$resourceAccessors = ['accounts', 'agencies', 'automations', 'campaigns', 'contacts', 'customFields', 'embedding', 'invitations', 'lists', 'messages', 'reports', 'roles', 'tags', 'templates', 'tickets', 'media', 'webhooks', 'partners', 'deprecatedPartners', 'partnerRoles', 'partnerInvitations', 'channels'];
foreach ($resourceAccessors as $accessor) {
$resource = $client->$accessor();
check($resource === $client->$accessor(), $accessor . ' returns its cached resource');
$reflection = new ReflectionClass($resource);
foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
    if ($method->getDeclaringClass()->getName() !== $reflection->getName() || $method->isStatic()) {
        continue;
    }
    $arguments = [];
    foreach ($method->getParameters() as $parameter) {
        $type = (string) $parameter->getType();
        $arguments[] = match ($type) {
            'int', 'string|int', 'int|string' => 7,
            'string' => '7',
            'array' => $parameter->name === 'query' ? ['search' => 'a & b', 'page' => 2] : ['sample' => 'value'],
            default => throw new RuntimeException('Unhandled parameter: ' . $parameter->name),
        };
    }
    $before = count($calls);
    check($method->invokeArgs($resource, $arguments) === '{"ok":true}', $method->name . ' response');
    check(count($calls) === $before + 1, $method->name . ' must perform one request');
    [$verb, $url, $headers, $body, $timeout] = $calls[array_key_last($calls)];
    $path = parse_url($url, PHP_URL_PATH);
    $key = $verb . ' ' . $path;
    check(isset($expected[$key]), $method->name . ' uses undocumented endpoint: ' . $key);
    check($timeout === 17, $method->name . ' timeout');
    check(count(array_filter($headers, static fn ($header) => str_starts_with($header, 'X-Spoki-Api-Key:'))) === (str_starts_with($path, '/wh/ap/') ? 0 : 1), $method->name . ' authentication');
    if ($verb === 'GET' || $verb === 'DELETE') {
        check($body === null, $method->name . ' unexpected request body');
    } else {
        json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    }
    $actual[$key] = true;
    $methods[] = $method->name;
    $resourceCall = $calls[array_key_last($calls)];
    check($client->{$method->name}(...$arguments) === '{"ok":true}', $method->name . ' legacy response');
    check($calls[array_key_last($calls)] === $resourceCall, $method->name . ' legacy request matches resource request');
}
}
check(array_diff_key($expected, $actual) === [], 'Missing endpoints: ' . implode(', ', array_keys(array_diff_key($expected, $actual))));

$sharedClient = new \MambuSRL\Spoki\Client('shared-key', null, 12, $transport);
$directContacts = new \MambuSRL\Spoki\Api\Contacts($sharedClient);
$directMessages = new \MambuSRL\Spoki\Api\Messages($sharedClient);
$directContacts->listContacts();
check(in_array('X-Spoki-Api-Key: shared-key', $calls[array_key_last($calls)][2], true), 'Direct resource authentication');
$sharedClient->setApiKey('updated-key');
$directMessages->sendMessageText('+390123', 'Hello');
check(in_array('X-Spoki-Api-Key: updated-key', $calls[array_key_last($calls)][2], true), 'Direct resources share client configuration');
check($calls[array_key_last($calls)][4] === 12, 'Direct resources share client timeout');
$client->setApiKey('facade-updated-key');
$client->contacts()->listContacts();
check(in_array('X-Spoki-Api-Key: facade-updated-key', $calls[array_key_last($calls)][2], true), 'Cached resource observes API key changes');
$client->setApiKey('test-key');
$client->sendMessageText(phone: '+390123', text: 'Named arguments');
check(json_decode($calls[array_key_last($calls)][3], true)['text'] === 'Named arguments', 'Legacy named arguments preserved');
$directAutomations = new \MambuSRL\Spoki\Api\Automations(new \MambuSRL\Spoki\Client('', null, 30, $transport));
$directAutomations->startAutomation('uuid', 'secret', '+390123');
check(!in_array('X-Spoki-Api-Key: ', $calls[array_key_last($calls)][2], true), 'Direct automation works without API key');
$beforeInvalidCalls = count($calls);
expectException(static fn () => $client->unknownOperation(), BadMethodCallException::class);
expectException(static fn () => $client->resource('contacts', 1), BadMethodCallException::class);
check(count($calls) === $beforeInvalidCalls, 'Unknown and protected methods do not send requests');
check(count(array_unique($methods)) === count($methods), 'Each API method has exactly one owning class');
foreach ($resourceAccessors as $accessor) {
    foreach ((new ReflectionClass($client->$accessor()))->getMethods() as $method) {
        $doc = $method->getDocComment();
        check($doc !== false && str_contains($doc, '@example'), $method->name . ' retains documentation and example');
        foreach ($method->getParameters() as $parameter) {
            check((bool) preg_match('/@param[^\n]*\$' . preg_quote($parameter->getName(), '/') . '\b/', $doc), $method->name . ' documents ' . $parameter->getName());
        }
    }
}

$client->listContacts(['search' => 'a & b', 'page' => 2]);
check(str_ends_with($calls[array_key_last($calls)][1], '?search=a%20%26%20b&page=2'), 'Query encoding');
$client->getChannelByPhone('+390123');
check(str_ends_with($calls[array_key_last($calls)][1], '/%2B390123/'), 'Phone encoding');
$client->getContact('abc/def');
check(str_ends_with($calls[array_key_last($calls)][1], '/abc%2Fdef/'), 'Identifier encoding');

$client->sendTemplate(42, '+390123', 'IT', ['url' => 'https://example.com/image.jpg'], ['NAME' => 'Mario'], [['order' => 0]], ['trace' => 1]);
$payload = json_decode($calls[array_key_last($calls)][3], true, 512, JSON_THROW_ON_ERROR);
check($payload === ['type' => 'Template', 'phone' => '+390123', 'header_media' => ['url' => 'https://example.com/image.jpg'], 'template' => 42, 'language' => 'IT', 'custom_fields' => ['NAME' => 'Mario'], 'buttons' => [['order' => 0]], 'metadata' => ['trace' => 1]], 'Legacy template payload');
$client->sendMessageText('+390123', 'Hello', ['trace' => 2]);
$payload = json_decode($calls[array_key_last($calls)][3], true, 512, JSON_THROW_ON_ERROR);
check($payload === ['type' => 'Message', 'content_type' => 'Text', 'phone' => '+390123', 'text' => 'Hello', 'metadata' => ['trace' => 2]], 'Legacy text payload');

foreach (['sendTemplateWithDynamicHeaderMedia', 'sendTemplateCarousel', 'sendTemplateCarouselMultilanguage', 'sendMessageWithButtons', 'sendMessageList'] as $name) {
    $client->$name(['phone' => '+390123', 'header_media_set' => [['url' => 'https://example.com/image.jpg', 'language' => 'it']], 'custom_fields' => ['CODE' => '10']]);
    $payload = json_decode($calls[array_key_last($calls)][3], true, 512, JSON_THROW_ON_ERROR);
    check($payload['custom_fields']['CODE'] === '10' && $payload['header_media_set'][0]['language'] === 'it', $name . ' preserves payload');
    check($payload['type'] === (str_starts_with($name, 'sendTemplate') ? 'Template' : 'Message'), $name . ' type');
    if (!str_starts_with($name, 'sendTemplate')) {
        check($payload['content_type'] === ($name === 'sendMessageList' ? 'List' : 'Interactive'), $name . ' content type');
    }
}
$client->syncContacts([['phone' => '+390123'], ['phone' => '+390124']]);
check(str_starts_with($calls[array_key_last($calls)][3], '['), 'Bulk contacts root must be an array');
$client->syncContacts([]);
check($calls[array_key_last($calls)][3] === '[]', 'Empty bulk contacts root must remain an array');
foreach (['blockContact' => true, 'unblockContact' => false] as $method => $blocked) {
    $client->$method(7);
    check(json_decode($calls[array_key_last($calls)][3], true)['is_blocked'] === $blocked, $method . ' state');
    check(!str_contains($calls[array_key_last($calls)][1], '?'), $method . ' query');
}

$anonymous = new Spoki('', null, 30, $transport);
$anonymous->startAutomation('automation-id', 'test-secret', '+390123', ['secret' => 'wrong', 'phone' => 'wrong', 'metadata' => ['id' => 1]]);
$payload = json_decode($calls[array_key_last($calls)][3], true);
check($payload['secret'] === 'test-secret' && $payload['phone'] === '+390123' && $payload['metadata']['id'] === 1, 'Automation body');
$anonymous->startAutomationBulk('automation-id', 'test-secret', [4 => ['phone' => '+390123']]);
check(json_decode($calls[array_key_last($calls)][3], true)['contacts'] === [['phone' => '+390123']], 'Bulk contacts array');
expectException(static fn () => $anonymous->listContacts(), LogicException::class);
expectException(static fn () => $anonymous->startAutomation('', 'secret', 'phone'), InvalidArgumentException::class);

foreach ([200, 201, 202, 204, 299] as $status) {
    $response = ['status' => $status, 'body' => $status === 204 ? '' : '{}'];
    check($client->listContacts() === $response['body'], 'Success status ' . $status);
}
check($client->requestJson('GET', '/api/1/contacts/') === [], 'Decoded JSON response');
$response = ['status' => 204, 'body' => ''];
check($client->requestJson('DELETE', '/api/1/contacts/7/') === null, 'Empty response');
foreach ([301, 400, 401, 403, 404, 429, 500] as $status) {
    $response = ['status' => $status, 'body' => '{"error":"test"}', 'headers' => ['retry-after' => '60']];
    $before = count($calls);
    $exception = expectException(static fn () => $client->listContacts(), SpokiException::class);
    check($exception instanceof SpokiException && $exception->statusCode === $status && $exception->responseBody === $response['body'] && $exception->responseHeaders['retry-after'] === '60', 'Structured HTTP error');
    check(count($calls) === $before + 1, 'No implicit retries');
}
$response = ['status' => 200, 'body' => '<html>invalid</html>'];
expectException(static fn () => $client->listContacts(), SpokiException::class);
expectException(static fn () => $client->sendMessage(['text' => "\xB1"]), JsonException::class);
expectException(static fn () => new Spoki("key\r\ninjected: true"), InvalidArgumentException::class);
expectException(static fn () => new Spoki('key', null, 0), InvalidArgumentException::class);
foreach (['http://example.com', 'https://user:pass@example.com', 'https://example.com/api/1', 'https://example.com?key=1'] as $url) {
    expectException(static fn () => new Spoki('key', $url), InvalidArgumentException::class);
}
foreach (['https://example.com', '//example.com', '/api/1/../secret/', '/api/1/%2e%2e/secret/'] as $path) {
    expectException(static fn () => $client->request('GET', $path), InvalidArgumentException::class);
}
expectException(static fn () => $client->getContact('..'), InvalidArgumentException::class);

$body = '{"event":"test"}';
$secret = 'test-webhook-secret';
$header = 't=1000,v2=' . hash_hmac('sha256', '1000.' . $body, $secret);
check(Spoki::verifyWebhookSignature($body, $header, $secret, 300, 1000), 'Valid signature');
check(!Spoki::verifyWebhookSignature($body . ' ', $header, $secret, 300, 1000), 'Modified body');
check(!Spoki::verifyWebhookSignature($body, $header, 'wrong', 300, 1000), 'Wrong secret');
check(!Spoki::verifyWebhookSignature($body, $header, $secret, 300, 1301), 'Old timestamp');
check(!Spoki::verifyWebhookSignature($body, $header, $secret, 300, 699), 'Future timestamp');
foreach (['', 't=1000', 't=1000,v2=x', 't=abc,v2=' . str_repeat('a', 64), $header . ',t=1000'] as $invalid) {
    check(!Spoki::verifyWebhookSignature($body, $invalid, $secret, 300, 1000), 'Malformed signature');
}

$curlClient = new Spoki('test-key');
$curlClient->sendMessageText('+390123', 'Hello');
check(CurlFixture::$closed === 1, 'cURL closed after success');
check(CurlFixture::$options[CURLOPT_FOLLOWLOCATION] === false, 'Redirects disabled');
check(CurlFixture::$options[CURLOPT_PROTOCOLS] === CURLPROTO_HTTPS, 'HTTPS enforced');
check(CurlFixture::$options[CURLOPT_TIMEOUT] === 30 && CurlFixture::$options[CURLOPT_CONNECTTIMEOUT] === 10, 'cURL timeouts');
check(!isset(CurlFixture::$options[CURLOPT_SSL_VERIFYPEER]) && !isset(CurlFixture::$options[CURLOPT_SSL_VERIFYHOST]), 'Default TLS verification preserved');
check(json_decode(CurlFixture::$options[CURLOPT_POSTFIELDS], true)['text'] === 'Hello', 'cURL JSON body');
CurlFixture::$status = 429;
$exception = expectException(static fn () => $curlClient->listContacts(), SpokiException::class);
check($exception instanceof SpokiException && $exception->responseHeaders['retry-after'] === '60', 'cURL response headers');
check(CurlFixture::$closed === 2, 'cURL closed after HTTP error');
check(!isset(CurlFixture::$options[CURLOPT_POSTFIELDS]), 'GET without body');
CurlFixture::$body = false;
expectException(static fn () => $curlClient->listContacts(), SpokiException::class);
check(CurlFixture::$closed === 3, 'cURL closed after transport failure');
CurlFixture::$initializationFails = true;
expectException(static fn () => $curlClient->listContacts(), SpokiException::class);

echo 'OK: ' . $checks . ' checks, ' . count($methods) . ' API methods, ' . count($expected) . " distinct documented endpoints. No network requests.\n";
}