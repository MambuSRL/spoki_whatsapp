<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Tags documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->tags();
 */
final class Tags extends ApiResource
{

    /**
     * List tags.
     *
     * GET /api/1/tags/
     *
     * Supported query fields:
     * : string.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $tags->listTags();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listTags(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/tags/', null, $query);
    }

    /**
     * Retrieve an existing tag.
     *
     * GET /api/1/tags/{{id}}/
     *
     * @param int|string $id Identifier of the tag to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $tags->getTag(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getTag(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('tags', $id));
    }
}
