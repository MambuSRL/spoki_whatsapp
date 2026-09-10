<?php

namespace MambuSRL\Spoki\Api;

use MambuSRL\Spoki\ApiResource;
use MambuSRL\Spoki\SpokiException;

/**
 * Operations for the Reports documentation folder.
 *
 * @example $api = (new \MambuSRL\Spoki\Spoki($apiKey))->reports();
 */
final class Reports extends ApiResource
{

    /**
     * Retrieve the legacy aggregated message and conversation report.
     *
     * GET /api/1/reports/
     *
     * Deprecated in the documentation, with a removal date of June 10, 2026.
     * Use listDetailedReports() with the same reporting query parameters.
     *
     * Supported query fields:
     * granularity: string ('Day', 'Month' or 'Year'). Day, Month or Year.
     * start_date: string (date in YYYY-MM-DD format). Start of the reporting interval.
     * end_date: string (date in YYYY-MM-DD format). End of the reporting interval.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @deprecated Use listDetailedReports(); the documentation announces removal on June 10, 2026.
     * @example $reports->listReports(['granularity' => 'Day', 'start_date' => '2026-09-01', 'end_date' => '2026-09-10']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listReports(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/reports/', null, $query);
    }

    /**
     * Retrieve detailed reports by channel, template category and message status.
     *
     * GET /api/1/reports/detailed/
     *
     * Supported query fields:
     * granularity: string ('Day', 'Month' or 'Year'). Day, Month or Year.
     * start_date: string (date in YYYY-MM-DD format). Start of the reporting interval.
     * end_date: string (date in YYYY-MM-DD format). End of the reporting interval.
     *
     * @param array<string, mixed> $query Endpoint query parameters; values are URL-encoded, not concatenated to the path.
     * @return string Original JSON response, or '' for a response without content.
     * @throws SpokiException Network failure, non-2xx HTTP status or invalid response JSON.
     * @throws \LogicException The operation requires an API key but none is configured.
     * @example $reports->listDetailedReports(['granularity' => 'Day', 'start_date' => '2026-09-01', 'end_date' => '2026-09-10']);
     * @see https://documenter.getpostman.com/view/21611004/UzBqnPvF
     */
    public function listDetailedReports(array $query = []): string
    {
        return $this->client->request('GET', '/api/1/reports/detailed/', null, $query);
    }
}
