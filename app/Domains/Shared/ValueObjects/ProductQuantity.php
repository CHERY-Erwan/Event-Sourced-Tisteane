<?php

declare(strict_types=1);

namespace App\Domains\Shared\ValueObjects;

use Symfony\Component\Routing\Exception\InvalidParameterException;

final class ProductQuantity
{
    public function __construct(
        private readonly int $quantity,
    ) {
        if ($this->quantity < 0) {
            throw new InvalidParameterException('Quantity must be above or equal to 0');
        }
    }

    /**
     * Instancie l'objet ProductQuantity avec une quantité.
     *
     * @param int $quantity
     * @return self
     */
    public static function from(int $quantity): self
    {
        return new self(quantity: $quantity);
    }

    /**
     * Retourne la quantité.
     */
    public function quantity(): int
    {
        return $this->quantity;
    }

    public function equals(self $other): bool
    {
        return $this->quantity === $other->quantity;
    }

    public function isZero(): bool
    {
        return $this->quantity === 0;
    }
}
