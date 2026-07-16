<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Exceptions;

use Illuminate\Http\Client\Response;
use RuntimeException;
use Throwable;

/**
 * Thrown when SofizPay returns an unsuccessful HTTP response.
 */
final class SofizPayRequestException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly ?Response $response = null,
        public readonly ?string $errorCode = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $response?->status() ?? 0, $previous);
    }

    /**
     * The raw JSON payload returned by the API, if any.
     *
     * @return array<string, mixed>
     */
    public function context(): array
    {
        return $this->response?->json() ?? [];
    }

    /**
     * The raw response body returned by the API, if any.
     *
     * @return string|null
     */
    public function body(): ?string
    {
        return $this->response?->body();
    }

    /**
     * Get the underlying HTTP response, when one is available.
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }
}
