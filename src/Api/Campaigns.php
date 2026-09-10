<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Campaigns documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->campaigns();
 */
final class Campaigns extends ApiResource
{

    /**
     * List campaigns.
     *
     * GET /api/1/campaigns/
     *
     * Supported query fields:
     * scheduled_datetime_gte: string (date in YYYY-MM-DD format).
     * scheduled_datetime_lte: string (date in YYYY-MM-DD format).
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $campaigns->listCampaigns();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listCampaigns(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/campaigns/', null, $query);
    }

    /**
     * Create a new campaign using the supplied fields.
     *
     * POST /api/1/campaigns/
     *
     * Payload fields and types (as documented for this operation):
     * name: string.
     * scheduled_datetime: string.
     * status: string.
     * automation: int.
     * lists: list<int>.
     * template: int.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $campaigns->createCampaign(['name' => 'Order updates', 'status' => 'Scheduled', 'scheduled_datetime' => '2026-10-01T09:00:00Z', 'automation' => 123, 'lists' => [456]]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createCampaign(array $data): string
    {
        return $this->client->request('POST', '/api/1/campaigns/', $data);
    }

    /**
     * Retrieve an existing campaign.
     *
     * GET /api/1/campaigns/{{id}}/
     *
     * @param int|string $id Identifier of the campaign to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $campaigns->getCampaign(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getCampaign(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('campaigns', $id));
    }

    /**
     * Update an existing campaign.
     *
     * PATCH /api/1/campaigns/{{id}}/
     *
     * Payload fields and types (as documented for this operation):
     * name: string.
     * scheduled_datetime: string.
     * status: string.
     * automation: int.
     * lists: list<int>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the campaign to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $campaigns->updateCampaign(123, ['name' => 'Order updates']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updateCampaign(int|string $id, array $data): string
    {
        return $this->client->request('PATCH', $this->resource('campaigns', $id), $data);
    }

    /**
     * Delete an existing campaign.
     *
     * DELETE /api/1/campaigns/{{id}}/
     *
     * @param int|string $id Identifier of the campaign to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $campaigns->deleteCampaign(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deleteCampaign(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('campaigns', $id));
    }
}
