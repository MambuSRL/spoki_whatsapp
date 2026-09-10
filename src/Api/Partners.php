<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Partners documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->partners();
 */
final class Partners extends ApiResource
{

    /**
     * List partners.
     *
     * GET /api/1/partners/
     *
     * No specific query fields are listed in the referenced example; pass [] by default.
     * Additional filters must be supported by the server. This method does not fetch all pages.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $partners->listPartners();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listPartners(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/partners/', null, $query);
    }

    /**
     * List the accounts associated with the authenticated partner.
     *
     * GET /api/1/partners/accounts/
     *
     * No specific query fields are listed in the referenced example; pass [] by default.
     * Additional filters must be supported by the server. This method does not fetch all pages.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $partners->listPartnerAccounts();
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listPartnerAccounts(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/partners/accounts/', null, $query);
    }

    /**
     * Create an onboarding link for a partner-managed account.
     *
     * POST /api/1/partners/onboarding/
     *
     * Payload fields and types (as documented for this operation):
     * account: int.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $partners->createPartnerOnboardingLink(['account' => 1]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createPartnerOnboardingLink(array $data): string
    {
        return $this->client->request('POST', '/api/1/partners/onboarding/', $data);
    }

    /**
     * Create an API key for a partner-managed account.
     *
     * POST /api/1/partners/create_api_key_for_account/
     *
     * Payload fields and types (as documented for this operation):
     * account: int.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $partners->createAccountApiKey(['account' => 1]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createAccountApiKey(array $data): string
    {
        return $this->client->request('POST', '/api/1/partners/create_api_key_for_account/', $data);
    }

    /**
     * Revoke the API key of a partner-managed account.
     *
     * POST /api/1/partners/revoke_api_key_for_account/
     *
     * Payload fields and types (as documented for this operation):
     * account: int.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $partners->revokeAccountApiKey(['account' => 1]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function revokeAccountApiKey(array $data): string
    {
        return $this->client->request('POST', '/api/1/partners/revoke_api_key_for_account/', $data);
    }

    /**
     * Create software-vendor client accounts from a JSON array of client records.
     *
     * POST /api/1/partners/add_sv_clients/
     *
     * Pass a non-empty sequential list of client objects, not a single client object.
     *
     * Payload fields and types (as documented for this operation):
     * [].account_name: string.
     * [].country: string.
     * [].country_code: string.
     * [].email: string.
     * [].first_name: string.
     * [].vat_amount: int.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param list<array<string, mixed>> $data Sequential JSON records; see the item fields above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $partners->addSoftwareVendorClients([['account_name' => 'Example client', 'country' => 'it', 'country_code' => 'IT', 'email' => 'alex@example.com', 'first_name' => 'Alex', 'vat_amount' => 2200]]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function addSoftwareVendorClients(array $data): string
    {
        return $this->client->request('POST', '/api/1/partners/add_sv_clients/', $data);
    }

    /**
     * Allocate Meta credit to a destination account.
     *
     * POST /api/1/partners/create_subrecharge/
     *
     * amount is an integer in thousandths: 10000 represents 10 monetary units.
     *
     * Payload fields and types (as documented for this operation):
     * destination_account: int.
     * amount: int.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $partners->createMetaCreditSubrecharge(['destination_account' => 1, 'amount' => 10000]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function createMetaCreditSubrecharge(array $data): string
    {
        return $this->client->request('POST', '/api/1/partners/create_subrecharge/', $data);
    }

    /**
     * Configure the profit margins of a software-vendor client account.
     *
     * POST /api/1/partners/set_profits/
     *
     * All *_profit_margin values are integers in thousandths: 49 represents 0.049.
     *
     * Payload fields and types (as documented for this operation):
     * destination_account: int.
     * sms_profit_margin: int.
     * sms_one_way_profit_margin: int.
     * utility_profit_margin: int.
     * authentication_profit_margin: int.
     * marketing_profit_margin: int.
     * service_profit_margin: int.
     * conversation_profit_margin: int.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $partners->setAccountProfitMargins(['destination_account' => 1, 'sms_profit_margin' => 49, 'sms_one_way_profit_margin' => 49, 'utility_profit_margin' => 49, 'authentication_profit_margin' => 49]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function setAccountProfitMargins(array $data): string
    {
        return $this->client->request('POST', '/api/1/partners/set_profits/', $data);
    }

    /**
     * Move credit from a software-vendor client account.
     *
     * POST /api/1/partners/move_credit_from_account/
     *
     * credit_to_move is an integer in thousandths: 10000 represents 10 monetary units.
     *
     * Payload fields and types (as documented for this operation):
     * account_id: int.
     * credit_to_move: int.
     *
     * An example field is not necessarily required. Send the fields needed by the operation;
     * for updates, include only the changes accepted by the endpoint.
     *
     * @param array<string, mixed> $data JSON payload fields described above.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @throws \JsonException The request payload cannot be encoded as JSON.
     * @example $partners->moveCreditFromAccount(['account_id' => 1, 'credit_to_move' => 10000]);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function moveCreditFromAccount(array $data): string
    {
        return $this->client->request('POST', '/api/1/partners/move_credit_from_account/', $data);
    }

    /**
     * Retrieve a usage report for a partner-managed account and date interval.
     *
     * GET /api/1/partners/get_account_report/
     *
     * Supported query fields:
     * account_id: int.
     * granularity: int (partner report granularity code).
     * startDate: string (date in YYYY-MM-DD format).
     * endDate: string (date in YYYY-MM-DD format).
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $partners->getPartnerAccountReport(['account_id' => 123, 'granularity' => 2, 'startDate' => '2026-09-01', 'endDate' => '2026-09-10']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getPartnerAccountReport(array $query): string
    {
        return $this->client->request('GET', '/api/1/partners/get_account_report/', null, $query);
    }

    /**
     * Retrieve credit or conversation forecasts for a partner-managed account.
     *
     * GET /api/1/partners/get_account_forecasts/
     *
     * Supported query fields:
     * account_id: int.
     * country_code: string.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $partners->getPartnerAccountForecasts(['account_id' => 123, 'country_code' => 'IT']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function getPartnerAccountForecasts(array $query): string
    {
        return $this->client->request('GET', '/api/1/partners/get_account_forecasts/', null, $query);
    }
}
