<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Webhooks documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->webhooks();
 */
final class Webhooks extends ApiResource
{

    /**
     * List outgoing webhook subscriptions.
     *
     * GET /api/1/external-webhooks/
     *
     * Supported query fields:
     * is_active: bool. true | false
     * event: string. Possible events: chat.has_unread_messages message.outbound message.inbound message.note contact.created contact.updated contact.deleted contact_tag.created contact_tag.deleted contact_list.created contact_list.deleted co
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $webhooks->listWebhooks();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listWebhooks(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/external-webhooks/', null, $query);
    }

    /**
     * Create a new outgoing webhook subscription using the supplied fields.
     *
     * POST /api/1/external-webhooks/
     *
     * Payload fields and types (as documented for this operation):
     * event: string.
     * version: int.
     * url: string.
     * is_active: bool.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $webhooks->createWebhook(['event' => 'example', 'version' => 2, 'url' => 'https://example.com/webhook', 'is_active' => true]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createWebhook(array $data): string
    {
        return $this->client->request('POST', '/api/1/external-webhooks/', $data);
    }

    /**
     * Retrieve an existing outgoing webhook subscription.
     *
     * GET /api/1/external-webhooks/{{id}}/
     *
     * @param int|string $id Identifier of the outgoing webhook subscription to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $webhooks->getWebhook(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getWebhook(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('external-webhooks', $id));
    }

    /**
     * Update an existing outgoing webhook subscription.
     *
     * PATCH /api/1/external-webhooks/{{id}}/
     *
     * Payload fields and types (as documented for this operation):
     * event: string.
     * version: int.
     * url: string.
     * is_active: bool.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the outgoing webhook subscription to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $webhooks->updateWebhook(123, ['event' => 'example', 'version' => 2, 'url' => 'https://example.com/webhook', 'is_active' => true]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updateWebhook(int|string $id, array $data): string
    {
        return $this->client->request('PATCH', $this->resource('external-webhooks', $id), $data);
    }

    /**
     * Delete an existing outgoing webhook subscription.
     *
     * DELETE /api/1/external-webhooks/{{id}}/
     *
     * @param int|string $id Identifier of the outgoing webhook subscription to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $webhooks->deleteWebhook(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deleteWebhook(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('external-webhooks', $id));
    }

    /**
     * Retrieve the related resources expanded in outgoing webhook payloads.
     *
     * GET /api/1/external-webhooks/{{id}}/expands/
     *
     * @param int|string $id Identifier of the outgoing webhook subscription to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $webhooks->getWebhookExpands(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getWebhookExpands(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('external-webhooks', $id, 'expands'));
    }

    /**
     * Configure which related resources are expanded in outgoing webhook payloads.
     *
     * POST /api/1/external-webhooks/{{id}}/expands/
     *
     * Payload fields and types (as documented for this operation):
     * expands: list<string>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the outgoing webhook subscription to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $webhooks->setWebhookExpands(123, ['expands' => ['contact']]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function setWebhookExpands(int|string $id, array $data): string
    {
        return $this->client->request('POST', $this->resource('external-webhooks', $id, 'expands'), $data);
    }

    /**
     * Ask Spoki to send a test event to a configured webhook destination.
     *
     * POST /api/1/external-webhooks/{{id}}/test/
     *
     * The documented example defines no body fields. Pass [] unless the API documents
     * additional fields for your operation or account configuration.
     *
     * @param int|string $id Identifier of the outgoing webhook subscription to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above; defaults to an empty object.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $webhooks->sendTestWebhook(123, []);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function sendTestWebhook(int|string $id, array $data = []): string
    {
        return $this->client->request('POST', $this->resource('external-webhooks', $id, 'test'), $data);
    }

    /**
     * Rotate the signing secret of an outgoing webhook subscription.
     *
     * POST /api/1/external-webhooks/{{id}}/rotate_secret/
     *
     * Store the returned secret securely and update the receiving application.
     * This changes webhook authentication and can affect in-flight deliveries.
     *
     * @param int|string $id Identifier of the outgoing webhook subscription to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $webhooks->rotateWebhookSecret(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function rotateWebhookSecret(int|string $id): string
    {
        return $this->client->request('POST', $this->resource('external-webhooks', $id, 'rotate_secret'), []);
    }

    /**
     * Verify a V2 webhook HMAC-SHA256 signature and its timestamp window.
     *
     * Verify the exact raw request body before decoding it. Re-encoding JSON changes the signature.
     * The header must contain t=<Unix timestamp>,v2=<64-character lowercase hex HMAC>.
     * The signing secret is distinct from both the account API key and automation trigger secret.
     * Rejects malformed headers, invalid signatures and timestamps outside the tolerance window.
     * V1 signatures are not accepted. Deduplicate event_uuid values in your application.
     *
     * @param string $payload Exact raw HTTP request body before JSON decoding or normalization.
     * @param string $header Complete X-Spoki-Signature header containing t and v2 values.
     * @param string $secret Outgoing webhook signing secret, not an automation trigger secret.
     * @param int $tolerance Allowed past/future timestamp drift in seconds; default 300; negative values fail.
     * @param int|null $now Unix timestamp override for deterministic tests; null uses time().
     * @return bool True only for a valid V2 signature within the timestamp window.
     * @example Webhooks::verifyWebhookSignature($rawBody, $_SERVER['HTTP_X_SPOKI_SIGNATURE'] ?? '', $secret);
     */
    public static function verifyWebhookSignature(string $payload, string $header, string $secret, int $tolerance = 300, ?int $now = null): bool
    {
        if ($secret === '' || $tolerance < 0) {
            return false;
        }
        $parts = [];
        foreach (explode(',', $header) as $part) {
            $pair = explode('=', trim($part), 2);
            if (count($pair) !== 2 || isset($parts[$pair[0]])) {
                return false;
            }
            $parts[$pair[0]] = $pair[1];
        }
        if (!isset($parts['t'], $parts['v2']) || !ctype_digit($parts['t']) ||
            !preg_match('/^[a-f0-9]{64}$/D', $parts['v2'])) {
            return false;
        }
        if (abs(($now ?? time()) - (int) $parts['t']) > $tolerance) {
            return false;
        }
        return hash_equals(hash_hmac('sha256', $parts['t'] . '.' . $payload, $secret), $parts['v2']);
    }
}
