<?php

namespace App\Domains\Cart;

use LogicException;
use App\Domains\Cart\Events\CartInitialized;
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
    public function initializeCart(?string $customerUuid, ?string $sessionId): self
    {
        if ($this->customerUuid || $this->sessionId) {
            throw new LogicException('Cart is already initialized');
        }

        if (!$customerUuid && !$sessionId) {
            throw new InvalidParameterException('Customer UUID or Session ID is required');
        }

        $this->recordThat(new CartInitialized(
            customerUuid: $customerUuid,
            sessionId: $sessionId,
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
