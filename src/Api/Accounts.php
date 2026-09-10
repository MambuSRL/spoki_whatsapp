<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Accounts documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->accounts();
 */
final class Accounts extends ApiResource
{

    /**
     * List accounts.
     *
     * GET /api/1/accounts/
     *
     * No specific query fields are listed in the referenced example; pass [] by default.
     * Additional filters must be supported by the server. This method does not fetch all pages.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $accounts->listAccounts();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listAccounts(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/accounts/', null, $query);
    }

    /**
     * Retrieve an existing account.
     *
     * GET /api/1/accounts/{{id}}/
     *
     * @param int|string $id Identifier of the account to operate on; not empty.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $accounts->getAccount(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getAccount(int|string $id): string
    {
        return $this->client->request('GET', $this->resource('accounts', $id));
    }

    /**
     * Retrieve an account by its international phone number.
     *
     * GET /api/1/accounts/phone/{{phone}}/
     *
     * @param string $phone International phone number as a string, including the + country prefix.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $accounts->getAccountByPhone('+393331234567');
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getAccountByPhone(string $phone): string
    {
        return $this->client->request('GET', $this->resource('accounts/phone', $phone));
    }

    /**
     * Retrieve the current usage report for an account.
     *
     * GET /api/1/accounts/{{id}}/current_report/
     *
     * The documented result may be cached by Spoki for 30 minutes.
     *
     * No specific query fields are listed in the referenced example; pass [] by default.
     * Additional filters must be supported by the server. This method does not fetch all pages.
     *
     * @param int|string $id Identifier of the account to operate on; not empty.
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @example $accounts->getAccountCurrentReport(123);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getAccountCurrentReport(int|string $id, array $query = []): string
    {
        return $this->client->request('GET', $this->resource('accounts', $id, 'current_report'), null, $query);
    }

    /**
     * Call the legacy account onboarding endpoint retained for compatibility.
     *
     * POST /api/1/accounts/{{id}}/onboarding/
     *
     * The current documentation marks this endpoint as removed and returning HTTP 404.
     * Use createChannel(['platform' => 1]) for the replacement onboarding flow.
     *
     * The documented example defines no body fields. Pass [] unless the API documents
     * additional fields for your operation or account configuration.
     *
     * @param int|string $id Identifier of the account to operate on; not empty.
     * @param array<string, mixed> $data JSON payload fields described above; defaults to an empty object.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @throws \InvalidArgumentException Invalid configuration, identifier or request path.
     * @deprecated Removed endpoint; use createChannel() with platform=1.
     * @example $accounts->createAccountOnboardingLink(123); // Legacy endpoint; expect HTTP 404.
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createAccountOnboardingLink(int|string $id, array $data = []): string
    {
        return $this->client->request('POST', $this->resource('accounts', $id, 'onboarding'), $data);
    }
}
