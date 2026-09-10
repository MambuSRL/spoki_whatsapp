<?php

namespace MambuSRL\Spoki\Api\Partners;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Partners / Deprecated documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->deprecatedPartners();
 */
final class Deprecated extends ApiResource
{

    /**
     * Call the deprecated conversation subrecharge endpoint for software vendors.
     *
     * POST /api/1/partners/create_conversations_subrecharge/
     *
     * Deprecated software-vendor-only endpoint; prefer createMetaCreditSubrecharge().
     *
     * Payload fields and types (as documented for this operation):
     * destination_account: int.
     * conversations: int.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @deprecated Use createMetaCreditSubrecharge() for credit-based allocation.
     * @example $deprecatedPartners->createConversationsSubrecharge(['destination_account' => 1, 'conversations' => 250]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createConversationsSubrecharge(array $data): string
    {
        return $this->client->request('POST', '/api/1/partners/create_conversations_subrecharge/', $data);
    }
}
