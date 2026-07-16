<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\Responses;

/**
 * Products returned by a SofizPay product search.
 */
final class ProductsResponse
{
    /**
     * @param array<int, array{name: string, price: string}> $products
     */
    public function __construct(
        public string $status,
        public int $count,
        public array $products = [],
    ) {
    }

    /**
     * @param array{
     *     status: string,
     *     count: int,
     *     products: array{ name: string, price: string }[]
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: data_get($data, 'status', 'error'),
            count: (int) data_get($data, 'count', 0),
            products: data_get($data, 'products', []),
        );
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'count' => $this->count,
            'products' => $this->products,
        ];
    }
}
