<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Responses;

/**
 * Pagination metadata returned with operation history.
 */
final class PaginationResponse
{
    public function __construct(
        public int $totalCount,
        public int $limit,
        public int $offset,
        public bool $hasMore,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            totalCount: (int) ($data['total_count'] ?? 0),
            limit: (int) ($data['limit'] ?? 0),
            offset: (int) ($data['offset'] ?? 0),
            hasMore: (bool) ($data['has_more'] ?? false),
        );
    }

    public function toArray(): array
    {
        return [
            'total_count' => $this->totalCount,
            'limit' => $this->limit,
            'offset' => $this->offset,
            'has_more' => $this->hasMore,
        ];
    }
}
