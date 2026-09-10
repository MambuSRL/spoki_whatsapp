<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Channels documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->channels();
 */
final class Channels extends ApiResource
{

    /**
     * List channels.
     *
     * GET /api/1/channel/
     *
     * Supported query fields:
     * whatsapp_business_account: string. Meta WABA identifier.
     * waba: string. Alias of whatsapp_business_account.
     * page: int. One-based page number; default 1.
     * page_size: int. Page size; default 15, maximum 30.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $channels->listChannels(['page' => 1, 'page_size' => 15, 'whatsapp_business_account' => '123456789']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listChannels(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/channel/', null, $query);
    }

    /**
     * Retrieve an existing channel.
     *
     * GET /api/1/channel/{{id_channel}}/
     *
     * @param int|string $id Identifier of the channel to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $channels->getChannel(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getChannel(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('channel', $id));
    }

    /**
     * Create a new channel using the supplied fields.
     *
     * POST /api/1/channel/
     *
     * The body depends on the platform. platform=1 starts WhatsApp onboarding.
     * The Postman example also shows platform=6 with name, identifier and is_primary.
     * Use a platform code supported by your account and the current provider documentation.
     *
     * Payload fields and types (as documented for this operation):
     * platform: int.
     * name: string.
     * is_primary: bool.
     * identifier: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $channels->createChannel(['platform' => 1]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createChannel(array $data): string
    {
        return $this->client->request('POST', '/api/1/channel/', $data);
    }

    /**
     * Update the display name of a channel.
     *
     * PATCH /api/1/channel/{{id_channel}}/
     *
     * Payload fields and types (as documented for this operation):
     * name: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the channel to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $channels->renameChannel(123, ['name' => 'Example']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function renameChannel(int|string $id, array $data): string
    {
        return $this->client->request('PATCH', $this->resource('channel', $id), $data);
    }

    /**
     * Mark a channel as the primary channel for its platform.
     *
     * POST /api/1/channel/{{id_channel}}/set-primary/
     *
     * @param int|string $id Identifier of the channel to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $channels->setPrimaryChannel(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function setPrimaryChannel(int|string $id): string
    {
        return $this->client->request('POST', $this->resource('channel', $id, 'set-primary'), []);
    }

    /**
     * Refresh the provider phone status of a WhatsApp channel.
     *
     * POST /api/1/channel/{{id_channel}}/refresh-wa-status/
     *
     * @param int|string $id Identifier of the channel to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $channels->refreshWhatsAppPhoneStatus(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function refreshWhatsAppPhoneStatus(int|string $id): string
    {
        return $this->client->request('POST', $this->resource('channel', $id, 'refresh-wa-status'), []);
    }

    /**
     * Look up a channel by its phone or platform identifier.
     *
     * GET /api/1/channel/phone/:identifier/
     *
     * @param string $phone International phone number as a string, including the + country prefix.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $channels->getChannelByPhone('+393331234567');
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getChannelByPhone(string $phone): string
    {
        return $this->client->request('GET', $this->resource('channel/phone', $phone));
    }
}
