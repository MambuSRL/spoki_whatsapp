<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the CustomFields documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->customFields();
 */
final class CustomFields extends ApiResource
{

    /**
     * List custom fields.
     *
     * GET /api/1/custom-fields/
     *
     * Supported query fields:
     * search: string. You can search by: 'label', 'code'
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $customFields->listCustomFields();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listCustomFields(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/custom-fields/', null, $query);
    }

    /**
     * Create a new custom field using the supplied fields.
     *
     * POST /api/1/custom-fields/
     *
     * Payload fields and types (as documented for this operation):
     * label: string.
     * code: string.
     * field_type: int.
     * example: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $customFields->createCustomField(['label' => 'Example', 'code' => 'Example', 'field_type' => 1, 'example' => 'Example']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createCustomField(array $data): string
    {
        return $this->client->request('POST', '/api/1/custom-fields/', $data);
    }

    /**
     * Retrieve an existing custom field.
     *
     * GET /api/1/custom-fields/{{id}}/
     *
     * @param int|string $id Identifier of the custom field to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $customFields->getCustomField(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getCustomField(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('custom-fields', $id));
    }

    /**
     * Update an existing custom field.
     *
     * PATCH /api/1/custom-fields/{{id}}/
     *
     * Payload fields and types (as documented for this operation):
     * label: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param int|string $id Identifier of the custom field to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $customFields->updateCustomField(123, ['label' => 'Example']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function updateCustomField(int|string $id, array $data): string
    {
        return $this->client->request('PATCH', $this->resource('custom-fields', $id), $data);
    }

    /**
     * Delete an existing custom field.
     *
     * DELETE /api/1/custom-fields/{{id}}/
     *
     * @param int|string $id Identifier of the custom field to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $customFields->deleteCustomField(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function deleteCustomField(int|string $id): string
    {
        return $this->client->request('DELETE', $this->resource('custom-fields', $id));
    }
}
