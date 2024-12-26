<?php

declare(strict_types=1);

namespace App\Domains\Shared\ValueObjects;

use Symfony\Component\Routing\Exception\InvalidParameterException;

final class Price
{
    public function __construct(
        private readonly int $amount,
    ) {
        if ($this->amount < 0) {
            throw new InvalidParameterException('Price must be above or equal to 0');
        }
    }

    /**
     * Instancie l'objet Price avec un prix.
     *
     * @param int $price
     * @return self
     */
    public static function from(int $amount): self
    {
        return new self(amount: $amount);
    }

    /**
     * Retourne le prix.
     */
    public function amount(): int
    {
        return $this->amount;
    }

    public function equals(self $other): bool
    {
        return $this->amount === $other->amount;
    }
}
