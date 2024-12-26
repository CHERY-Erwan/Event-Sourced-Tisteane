<?php

namespace App\Domains\Cart;

use LogicException;
use App\Domains\Cart\Events\CartInitialized;
use App\Domains\Shared\ValueObjects\CartIdentifiers;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class CartAggregateRoot extends AggregateRoot
{
    protected ?string $customerUuid = null;
    protected ?string $sessionId = null;

    /**
     * Initialise un panier pour un client ou une session.
     *
     * @param string|null $customerUuid
     * @param string|null $sessionId
     * @return self
     * @throws LogicException
     * @throws InvalidParameterException
     */
    public function initializeCart(CartIdentifiers $cartIdentifiers): self
    {
        if ($this->customerUuid || $this->sessionId) {
            throw new LogicException('Cart is already initialized');
        }

        $this->recordThat(new CartInitialized(
            customerUuid: $cartIdentifiers->customerUuid,
            sessionId: $cartIdentifiers->sessionId,
        ));

        return $this;
    }

    /**
     * Applique les effets de l'événement `CartInitialized`.
     *
     * @param CartInitialized $event
     */
    protected function applyCartInitialized(CartInitialized $event): void
    {
        $this->customerUuid = $event->customerUuid;
        $this->sessionId = $event->sessionId;
    }
}
