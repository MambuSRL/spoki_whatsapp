<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Agencies documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->agencies();
 */
final class Agencies extends ApiResource
{

    /**
     * List agencies.
     *
     * GET /api/1/agencies/
     *
     * No specific query fields are listed in the referenced example; pass [] by default.
     * Additional filters must be supported by the server. This method does not fetch all pages.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $agencies->listAgencies();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listAgencies(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/agencies/', null, $query);
    }

    /**
     * Retrieve an existing agency.
     *
     * GET /api/1/agencies/{{id}}/
     *
     * @param int|string $id Identifier of the agency to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $agencies->getAgency(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getAgency(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('agencies', $id));
    }
}
