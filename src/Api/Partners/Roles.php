<?php

namespace MambuSRL\Spoki\Api\Partners;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Partners / Roles documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->partnerRoles();
 */
final class Roles extends ApiResource
{

    /**
     * List partner roles.
     *
     * GET /api/1/partner-roles/
     *
     * Supported query fields:
     * search: string. search by id, email, first_name, last_name
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $partnerRoles->listPartnerRoles();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listPartnerRoles(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/partner-roles/', null, $query);
    }

    /**
     * Retrieve an existing partner role.
     *
     * GET /api/1/partner-roles/{{id}}/
     *
     * @param int|string $id Identifier of the partner role to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $partnerRoles->getPartnerRole(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getPartnerRole(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('partner-roles', $id));
    }

    /**
     * Generate a private key for a partner role.
     *
     * POST /api/1/partner-roles/{{id}}/generate_private_key/
     *
     * The documented example defines no body fields. Pass [] unless the API documents
     * additional fields for your operation or account configuration.
     *
     * @param int|string $id Identifier of the partner role to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above; defaults to an empty object.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $partnerRoles->generatePartnerRolePrivateKey(123, []);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function generatePartnerRolePrivateKey(int|string $id, array $data = []): string
    {
        return $this->client->request('POST', $this->resource('partner-roles', $id, 'generate_private_key'), $data);
    }

    /**
     * Check whether a partner role has a private key.
     *
     * GET /api/1/partner-roles/{{id}}/has_private_key/
     *
     * @param int|string $id Identifier of the partner role to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $partnerRoles->hasPartnerRolePrivateKey(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function hasPartnerRolePrivateKey(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('partner-roles', $id, 'has_private_key'));
    }

    /**
     * Change the access role of a partner user.
     *
     * POST /api/1/partner-roles/{{id}}/update_role/
     *
     * Payload fields and types (as documented for this operation):
     * role: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the partner role to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $partnerRoles->updatePartnerRole(123, ['role' => 'Chat Operator']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updatePartnerRole(int|string $id, array $data): string
    {
        return $this->client->request('POST', $this->resource('partner-roles', $id, 'update_role'), $data);
    }

    /**
     * Delete an existing partner role.
     *
     * DELETE /api/1/partner-roles/{{id}}/
     *
     * @param int|string $id Identifier of the partner role to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $partnerRoles->deletePartnerRole(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deletePartnerRole(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('partner-roles', $id));
    }
}
