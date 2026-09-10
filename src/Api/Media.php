<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Media documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->media();
 */
final class Media extends ApiResource
{

    /**
     * List media resources.
     *
     * GET /api/1/media/
     *
     * Supported query fields:
     * : string.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $media->listMedia();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listMedia(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/media/', null, $query);
    }

    /**
     * Create a new media resource using the supplied fields.
     *
     * POST /api/1/media/
     *
     * Registers external media by URL; this method does not upload local files or multipart data.
     *
     * Payload fields and types (as documented for this operation):
     * title: string.
     * external_url: string.
     * format_type: string.
     * content_type: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $media->createMedia(['title' => 'Example', 'external_url' => 'https://example.com/webhook', 'format_type' => 'image', 'content_type' => 'image/jpeg']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createMedia(array $data): string
    {
        return $this->client->request('POST', '/api/1/media/', $data);
    }

    /**
     * Retrieve an existing media resource.
     *
     * GET /api/1/media/{{id}}/
     *
     * @param int|string $id Identifier of the media resource to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $media->getMedia(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getMedia(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('media', $id));
    }

    /**
     * Update an existing media resource.
     *
     * PATCH /api/1/media/{{id}}/
     *
     * Payload fields and types (as documented for this operation):
     * title: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the media resource to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $media->updateMedia(123, ['title' => 'Example']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updateMedia(int|string $id, array $data): string
    {
        return $this->client->request('PATCH', $this->resource('media', $id), $data);
    }

    /**
     * Delete an existing media resource.
     *
     * DELETE /api/1/media/{{id}}/
     *
     * @param int|string $id Identifier of the media resource to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $media->deleteMedia(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deleteMedia(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('media', $id));
    }
}
