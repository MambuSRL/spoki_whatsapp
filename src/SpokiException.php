<?php

namespace MambuSRL\Spoki;

/**
 * A Spoki HTTP, transport or response-format failure with structured response details.
 * Response bodies can contain personal data or secrets; filter them before logging.
 */
final class SpokiException extends \RuntimeException
{
    /**
     * Create an exception while preserving the HTTP response and underlying failure.
     *
     * @param string $message Safe error summary; avoid embedding keys or request payloads.
     * @param int $statusCode HTTP response status, or 0 when no HTTP response is available.
     * @param string $responseBody Original response body; empty if unavailable.
     * @param array<string, string> $responseHeaders Response headers keyed by lowercase names.
     * @param \Throwable|null $previous Underlying exception, such as a JSON decoding failure.
     * @example throw new SpokiException('Request failed.', 429, $body, ['retry-after' => '60']);
     */
    public function __construct(
        string $message,
        public readonly int $statusCode = 0,
        public readonly string $responseBody = '',
        public readonly array $responseHeaders = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $previous);
    }
}