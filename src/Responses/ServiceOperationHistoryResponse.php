<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Responses;

/**
 * A page of service-operation history.
 */
final class ServiceOperationHistoryResponse
{
    /**
     * @param array<int, ServiceOperationDetailsResponse> $operations
     */
    public function __construct(
        public array $operations,
        public PaginationResponse $pagination,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $data = $data['data'] ?? $data;

        $operations = array_map(
            fn (array $operation) => ServiceOperationDetailsResponse::fromArray($operation),
            $data['operations'] ?? []
        );

        return new self(
            operations: $operations,
            pagination: PaginationResponse::fromArray($data['pagination'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'operations' => array_map(fn (ServiceOperationDetailsResponse $op) => $op->toArray(), $this->operations),
            'pagination' => $this->pagination->toArray(),
        ];
    }
}
