<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Invitations documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->invitations();
 */
final class Invitations extends ApiResource
{

    /**
     * List invitations.
     *
     * GET /api/1/invitations/
     *
     * Supported query fields:
     * search: string. search by id, email, first_name, last_name
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $invitations->listInvitations();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listInvitations(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/invitations/', null, $query);
    }

    /**
     * Retrieve an existing invitation.
     *
     * GET /api/1/invitations/{{id}}/
     *
     * @param int|string $id Identifier of the invitation to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $invitations->getInvitation(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getInvitation(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('invitations', $id));
    }

    /**
     * Create a new invitation using the supplied fields.
     *
     * POST /api/1/invitations/
     *
     * Payload fields and types (as documented for this operation):
     * email: string.
     * role: string.
     * additional_info: array<string, mixed>.
     * additional_info.first_name: string.
     * additional_info.last_name: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $invitations->createInvitation(['email' => 'alex@example.com', 'role' => 'Administrator', 'additional_info' => ['first_name' => 'Example', 'last_name' => 'Example']]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createInvitation(array $data): string
    {
        return $this->client->request('POST', '/api/1/invitations/', $data);
    }

    /**
     * Resend the email for an existing account invitation.
     *
     * POST /api/1/invitations/{{id}}/send/
     *
     * The documented example defines no body fields. Pass [] unless the API documents
     * additional fields for your operation or account configuration.
     *
     * @param int|string $id Identifier of the invitation to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above; defaults to an empty object.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $invitations->resendInvitation(123, []);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function resendInvitation(int|string $id, array $data = []): string
    {
        return $this->client->request('POST', $this->resource('invitations', $id, 'send'), $data);
    }

    /**
     * Change the role granted by an account invitation.
     *
     * POST /api/1/invitations/{{id}}/update_role/
     *
     * Payload fields and types (as documented for this operation):
     * role: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the invitation to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $invitations->updateInvitationRole(123, ['role' => 'Chat Operator Manager']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updateInvitationRole(int|string $id, array $data): string
    {
        return $this->client->request('POST', $this->resource('invitations', $id, 'update_role'), $data);
    }

    /**
     * Delete an existing invitation.
     *
     * DELETE /api/1/invitations/{{id}}/
     *
     * @param int|string $id Identifier of the invitation to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $invitations->deleteInvitation(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deleteInvitation(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('invitations', $id));
    }
}
