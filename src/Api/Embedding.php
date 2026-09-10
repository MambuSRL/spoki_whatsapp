<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Embedding documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->embedding();
 */
final class Embedding extends ApiResource
{

    /**
     * Obtain an authentication token for embedding Spoki in an iframe.
     *
     * POST /api/1/auth/get_authentication_token/
     *
     * Requires email and private_key in the body plus the configured X-Spoki-Api-Key header.
     * The private key is a user/service key, not the account API key.
     *
     * Payload fields and types (as documented for this operation):
     * email: string.
     * private_key: string.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $embedding->getAuthenticationToken(['email' => 'alex@example.com', 'private_key' => $secret]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getAuthenticationToken(array $data): string
    {
        return $this->client->request('POST', '/api/1/auth/get_authentication_token/', $data);
    }
}
