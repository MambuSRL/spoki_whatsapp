<?php

namespace MambuSRL\Spoki\Api\Partners;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Partners / Invitations documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->partnerInvitations();
 */
final class Invitations extends ApiResource
{

    /**
     * List partner invitations.
     *
     * GET /api/1/partner-invitations/
     *
     * Supported query fields:
     * search: string. search by id, email, first_name, last_name
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $partnerInvitations->listPartnerInvitations();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listPartnerInvitations(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/partner-invitations/', null, $query);
    }

    /**
     * Retrieve an existing partner invitation.
     *
     * GET /api/1/partner-invitations/{{id}}/
     *
     * @param int|string $id Identifier of the partner invitation to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $partnerInvitations->getPartnerInvitation(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getPartnerInvitation(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('partner-invitations', $id));
    }

    /**
     * Create a new partner invitation using the supplied fields.
     *
     * POST /api/1/partner-invitations/
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
     * @example $partnerInvitations->createPartnerInvitation(['email' => 'alex@example.com', 'role' => 'Administrator', 'additional_info' => ['first_name' => 'Example', 'last_name' => 'Example']]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createPartnerInvitation(array $data): string
    {
        return $this->client->request('POST', '/api/1/partner-invitations/', $data);
    }

    /**
     * Resend the email for an existing partner invitation.
     *
     * POST /api/1/partner-invitations/{{id}}/send/
     *
     * The documented example defines no body fields. Pass [] unless the API documents
     * additional fields for your operation or account configuration.
     *
     * @param int|string $id Identifier of the partner invitation to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above; defaults to an empty object.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $partnerInvitations->resendPartnerInvitation(123, []);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function resendPartnerInvitation(int|string $id, array $data = []): string
    {
        return $this->client->request('POST', $this->resource('partner-invitations', $id, 'send'), $data);
    }

    /**
     * Change the role granted by a partner invitation.
     *
     * POST /api/1/partner-invitations/{{id}}/update_role/
     *
     * Payload fields and types (as documented for this operation):
     * role: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the partner invitation to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $partnerInvitations->updatePartnerInvitationRole(123, ['role' => 'Chat Operator Manager']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updatePartnerInvitationRole(int|string $id, array $data): string
    {
        return $this->client->request('POST', $this->resource('partner-invitations', $id, 'update_role'), $data);
    }

    /**
     * Delete an existing partner invitation.
     *
     * DELETE /api/1/partner-invitations/{{id}}/
     *
     * @param int|string $id Identifier of the partner invitation to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $partnerInvitations->deletePartnerInvitation(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deletePartnerInvitation(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('partner-invitations', $id));
    }
}
