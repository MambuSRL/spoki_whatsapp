<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Lists documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->lists();
 */
final class Lists extends ApiResource
{

    /**
     * List contact lists.
     *
     * GET /api/1/lists/
     *
     * Supported query fields:
     * search: string. You can search by list name
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $lists->listLists();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listLists(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/lists/', null, $query);
    }

    /**
     * Create a new contact list using the supplied fields.
     *
     * POST /api/1/lists/
     *
     * Payload fields and types (as documented for this operation):
     * name: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $lists->createList(['name' => 'Example']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createList(array $data): string
    {
        return $this->client->request('POST', '/api/1/lists/', $data);
    }

    /**
     * Retrieve an existing contact list.
     *
     * GET /api/1/lists/{{id}}/
     *
     * @param int|string $id Identifier of the contact list to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $lists->getList(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getList(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('lists', $id));
    }

    /**
     * Create or update contacts and add them to an existing list.
     *
     * POST /api/1/lists/{{id}}/sync_contacts/
     *
     * Unlike syncContacts(), this endpoint expects an object containing a contacts list.
     *
     * Payload fields and types (as documented for this operation):
     * contacts: list<array<string, mixed>>.
     * contacts[].phone: string.
     * contacts[].first_name: string.
     * contacts[].last_name: string.
     * contacts[].email: string.
     * contacts[].language: string.
     * contacts[].custom_fields: array<string, string>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the contact list to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $lists->syncListContacts(123, ['contacts' => [['phone' => '+393331234567']]]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function syncListContacts(int|string $id, array $data): string
    {
        return $this->client->request('POST', $this->resource('lists', $id, 'sync_contacts'), $data);
    }

    /**
     * Remove all contact memberships from a list.
     *
     * POST /api/1/lists/{{id}}/remove_all_contacts/
     *
     * @param int|string $id Identifier of the contact list to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $lists->removeAllListContacts(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function removeAllListContacts(int|string $id): string
    {
        return $this->client->request('POST', $this->resource('lists', $id, 'remove_all_contacts'), []);
    }

    /**
     * Remove selected contacts from a list using email addresses, phone numbers or IDs.
     *
     * POST /api/1/lists/{{id}}/remove_contacts/
     *
     * Use the selector arrays supported by the endpoint; these remove list memberships.
     * Phone values are strings, not numbers, to preserve international prefixes.
     *
     * Payload fields and types (as documented for this operation):
     * emails: list<string>.
     * phones: list<string>.
     * ids: list<int>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the contact list to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $lists->removeListContacts(123, ['ids' => [456, 789]]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function removeListContacts(int|string $id, array $data): string
    {
        return $this->client->request('POST', $this->resource('lists', $id, 'remove_contacts'), $data);
    }

    /**
     * Delete an existing contact list.
     *
     * DELETE /api/1/lists/{{id}}/
     *
     * @param int|string $id Identifier of the contact list to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $lists->deleteList(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deleteList(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('lists', $id));
    }
}
