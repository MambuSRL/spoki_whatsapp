<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Roles documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->roles();
 */
final class Roles extends ApiResource
{

    /**
     * List roles.
     *
     * GET /api/1/roles/
     *
     * Supported query fields:
     * search: string. search by id, email, first_name, last_name
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $roles->listRoles();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listRoles(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/roles/', null, $query);
    }

    /**
     * Retrieve an existing role.
     *
     * GET /api/1/roles/{{id}}/
     *
     * @param int|string $id Identifier of the role to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $roles->getRole(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getRole(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('roles', $id));
    }

    /**
     * Create a service user with a display name and account role.
     *
     * POST /api/1/roles/add_service_user/
     *
     * Payload fields and types (as documented for this operation):
     * role: string.
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
     * @example $roles->addServiceUser(['role' => 'Administrator', 'name' => 'Example']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function addServiceUser(array $data): string
    {
        return $this->client->request('POST', '/api/1/roles/add_service_user/', $data);
    }

    /**
     * Generate a private key for an account role.
     *
     * POST /api/1/roles/{{id}}/generate_private_key/
     *
     * The documented example defines no body fields. Pass [] unless the API documents
     * additional fields for your operation or account configuration.
     *
     * @param int|string $id Identifier of the role to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above; defaults to an empty object.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $roles->generateRolePrivateKey(123, []);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function generateRolePrivateKey(int|string $id, array $data = []): string
    {
        return $this->client->request('POST', $this->resource('roles', $id, 'generate_private_key'), $data);
    }

    /**
     * Check whether an account role has a private key.
     *
     * GET /api/1/roles/{{id}}/has_private_key/
     *
     * @param int|string $id Identifier of the role to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $roles->hasRolePrivateKey(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function hasRolePrivateKey(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('roles', $id, 'has_private_key'));
    }

    /**
     * Change the access role of an account user.
     *
     * POST /api/1/roles/{{id}}/update_role/
     *
     * Payload fields and types (as documented for this operation):
     * role: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the role to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $roles->updateRole(123, ['role' => 'Chat Operator']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updateRole(int|string $id, array $data): string
    {
        return $this->client->request('POST', $this->resource('roles', $id, 'update_role'), $data);
    }

    /**
     * Delete an existing role.
     *
     * DELETE /api/1/roles/{{id}}/
     *
     * @param int|string $id Identifier of the role to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $roles->deleteRole(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deleteRole(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('roles', $id));
    }
}
