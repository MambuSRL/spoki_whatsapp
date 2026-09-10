<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Contacts documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->contacts();
 */
final class Contacts extends ApiResource
{

    /**
     * List contacts.
     *
     * GET /api/1/contacts/
     *
     * Supported query fields:
     * search: string. Search in: 'phone', 'email', 'first_name', 'last_name', 'language', 'notes'
     * tag: int. Filter by tag id
     * is_blocked: bool. true | false Get blocked contacts only
     * email: string. e.g. john.doe@domain.com
     * phone: string. e.g. +393331234567
     * language: string. e.g. 'en'
     * first_name: string. e.g. 'John'
     * last_name: string. e.g. 'Doe'
     * status: string. Not Declared | Subscribed | Unsubscribed
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $contacts->listContacts();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listContacts(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/contacts/', null, $query);
    }

    /**
     * Create or update multiple contacts using a JSON array at the request root.
     *
     * POST /api/1/contacts/sync_all/
     *
     * Pass a non-empty sequential list, not an object containing a contacts key.
     * Each contact needs a phone. The documented maximum batch size is 500.
     * Marketing status values are Not Declared, Subscribed or Unsubscribed.
     *
     * Payload fields and types (as documented for this operation):
     * [].phone: string.
     * [].first_name: string.
     * [].last_name: string.
     * [].email: string.
     * [].language: string.
     * [].status: string.
     * [].custom_fields: array<string, string>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param list<array<string, mixed>> $data Sequential JSON records; see the item fields above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $contacts->syncContacts([['phone' => '+393331234567', 'first_name' => 'Alex']]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function syncContacts(array $data): string
    {
        return $this->client->request('POST', '/api/1/contacts/sync_all/', $data);
    }

    /**
     * Assign an operator to a contact using the operator email address.
     *
     * POST /api/1/contacts/{{id}}/add_operator/
     *
     * Payload fields and types (as documented for this operation):
     * email: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the contact to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $contacts->addContactOperator(123, ['email' => 'alex@example.com']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function addContactOperator(int|string $id, array $data): string
    {
        return $this->client->request('POST', $this->resource('contacts', $id, 'add_operator'), $data);
    }

    /**
     * Remove an operator assignment from a contact using the operator email address.
     *
     * POST /api/1/contacts/{{id}}/remove_operator/
     *
     * Payload fields and types (as documented for this operation):
     * email: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the contact to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $contacts->removeContactOperator(123, ['email' => 'alex@example.com']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function removeContactOperator(int|string $id, array $data): string
    {
        return $this->client->request('POST', $this->resource('contacts', $id, 'remove_operator'), $data);
    }

    /**
     * Create or update a contact identified by its phone number.
     *
     * POST /api/1/contacts/sync/
     *
     * phone identifies the contact. Marketing status values are Not Declared, Subscribed or Unsubscribed.
     * Changing marketing status may trigger an automation on the server.
     *
     * Payload fields and types (as documented for this operation):
     * phone: string.
     * first_name: string.
     * last_name: string.
     * email: string.
     * language: string.
     * status: string.
     * custom_fields: array<string, string>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $contacts->syncContact(['phone' => '+393331234567', 'first_name' => 'Alex']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function syncContact(array $data): string
    {
        return $this->client->request('POST', '/api/1/contacts/sync/', $data);
    }

    /**
     * Retrieve an existing contact.
     *
     * GET /api/1/contacts/{{id}}/
     *
     * @param int|string $id Identifier of the contact to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $contacts->getContact(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getContact(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('contacts', $id));
    }

    /**
     * Update an existing contact.
     *
     * PATCH /api/1/contacts/{{id}}/
     *
     * Payload fields and types (as documented for this operation):
     * phone: string.
     * first_name: string.
     * last_name: string.
     * email: string.
     * language: string.
     * custom_fields: array<string, string>.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the contact to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $contacts->updateContact(123, ['first_name' => 'Alex']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updateContact(int|string $id, array $data): string
    {
        return $this->client->request('PATCH', $this->resource('contacts', $id), $data);
    }

    /**
     * Delete an existing contact.
     *
     * DELETE /api/1/contacts/{{id}}/
     *
     * @param int|string $id Identifier of the contact to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $contacts->deleteContact(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deleteContact(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('contacts', $id));
    }

    /**
     * Block a contact by setting is_blocked to true.
     *
     * PATCH /api/1/contacts/{{id}}/
     *
     * @param int|string $id Identifier of the contact to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $contacts->blockContact(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function blockContact(int|string $id): string
    {
        return $this->updateContact($id, ['is_blocked' => true]);
    }

    /**
     * Unblock a contact by setting is_blocked to false.
     *
     * PATCH /api/1/contacts/{{id}}/
     *
     * Sends is_blocked=false in the body without the contradictory is_blocked=true query
     * shown in the Postman example. No other contact fields are changed by this helper.
     *
     * @param int|string $id Identifier of the contact to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $contacts->unblockContact(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function unblockContact(int|string $id): string
    {
        return $this->updateContact($id, ['is_blocked' => false]);
    }
}
