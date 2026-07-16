<?php

declare(strict_types=1);

namespace OussamaMadjmaa\SofizPay\DTOs;

use Illuminate\Support\Str;

/**
 * Data required to create a CIB transaction.
 */
final class MakeCIBTransactionDTO
{
    public function __construct(
        public readonly float $amount,
        public readonly string $fullName,
        public readonly string $phone,
        public readonly string $email,
        public readonly string $returnUrl,
        public ?string $memo = null,
        public readonly string $redirect = 'no',
        public readonly bool $keepReturnUrl = false,
        public readonly ?string $account = null,
    ) {
        if (!is_null($this->memo)) {
            $this->memo = Str::of($this->memo)->limit(28)->toString();
        }
    }

    /**
     * Create DTO from request data.
     *
     * @param array{
     *     amount: float,
     *     full_name: string,
     *     phone: string,
     *     email: string,
     *     return_url: string,
     *     account?: string,
     *     memo?: string,
     *     redirect?: string,
     *     keep_return_url?: bool
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            account: $data['account'] ?? null,
            amount: $data['amount'],
            fullName: $data['full_name'],
            phone: $data['phone'],
            email: $data['email'],
            returnUrl: $data['return_url'],
            memo: $data['memo'] ?? null,
            redirect: $data['redirect'] ?? 'no',
            keepReturnUrl: $data['keep_return_url'] ?? false
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'account' => $this->account,
            'amount' => $this->amount,
            'full_name' => $this->fullName,
            'phone' => $this->phone,
            'email' => $this->email,
            'return_url' => $this->returnUrl,
            'memo' => $this->memo,
            'redirect' => $this->redirect,
            'keep_return_url' => $this->keepReturnUrl,
        ], fn ($value) => !is_null($value));
    }
}
