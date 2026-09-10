<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Tickets documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->tickets();
 */
final class Tickets extends ApiResource
{

    /**
     * List tickets.
     *
     * GET /api/1/tickets/
     *
     * Supported query fields:
     * : string.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $tickets->listTickets();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listTickets(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/tickets/', null, $query);
    }

    /**
     * Create a new ticket using the supplied fields.
     *
     * POST /api/1/tickets/
     *
     * Payload fields and types (as documented for this operation):
     * contact_phone: string.
     * title: string.
     * status: string.
     * priority: string.
     * description: string.
     * reference: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $tickets->createTicket(['contact_phone' => '+393331234567', 'title' => 'Example', 'status' => 'Open', 'priority' => 'Medium', 'description' => 'Example']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createTicket(array $data): string
    {
        return $this->client->request('POST', '/api/1/tickets/', $data);
    }

    /**
     * Retrieve an existing ticket.
     *
     * GET /api/1/tickets/{{id}}/
     *
     * @param int|string $id Identifier of the ticket to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $tickets->getTicket(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getTicket(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('tickets', $id));
    }

    /**
     * Update an existing ticket.
     *
     * PATCH /api/1/tickets/{{id}}/
     *
     * Payload fields and types (as documented for this operation):
     * contact_phone: string.
     * title: string.
     * status: string.
     * priority: string.
     * description: string.
     * reference: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the ticket to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $tickets->updateTicket(123, ['contact_phone' => '+393331234567', 'title' => 'Example', 'status' => 'Open', 'priority' => 'Medium', 'description' => 'Example']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updateTicket(int|string $id, array $data): string
    {
        return $this->client->request('PATCH', $this->resource('tickets', $id), $data);
    }

    /**
     * Delete an existing ticket.
     *
     * DELETE /api/1/tickets/{{id}}/
     *
     * @param int|string $id Identifier of the ticket to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $tickets->deleteTicket(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deleteTicket(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('tickets', $id));
    }
}
