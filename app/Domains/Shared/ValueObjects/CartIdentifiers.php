<?php

declare(strict_types=1);

namespace App\Domains\Shared\ValueObjects;

use Symfony\Component\Routing\Exception\InvalidParameterException;
use Ramsey\Uuid\Uuid;

final class CartIdentifiers
{
    public function __construct(
        public readonly ?string $customerUuid,
        public readonly ?string $sessionId,
    ) {
        $this->validate();
    }

    /**
     * Instancie l'objet CartIdentifiers avec un UUID de client ou un ID de session.
     *
     * @param ?string $customerUuid UUID de l'utilisateur
     * @param ?string $sessionId ID de la session
     * @return self
     */
    public static function with(?string $customerUuid, ?string $sessionId): self
    {
        return new self(
            customerUuid: $customerUuid,
            sessionId: $sessionId,
        );
    }

    /**
     * Valide les identifiants.
     *
     * @throws InvalidParameterException
     */
    private function validate(): void
    {
        if (!$this->customerUuid && !$this->sessionId) {
            throw new InvalidParameterException('Customer UUID or Session ID is required');
        }

        if ($this->customerUuid && !Uuid::isValid($this->customerUuid)) {
            throw new InvalidParameterException('Customer UUID is invalid');
        }

        if ($this->sessionId && $this->isValidSessionId($this->sessionId) === false) {
            throw new InvalidParameterException('Session ID is invalid');
        }
    }

    /**
     * Vérifie si l'ID de session est valide.
     *
     * @param string $sessionId
     * @return bool
     */
    private function isValidSessionId(string $sessionId): bool
    {
        return preg_match('/^[a-zA-Z0-9]{32,64}$/', $sessionId) === 1;
    }

    /**
     * Vérifie si l'utilisateur est un invité.
     */
    public function isGuest(): bool
    {
        return !empty($this->sessionId) && empty($this->customerUuid);
    }

    /**
     * Vérifie si l'utilisateur est un utilisateur enregistré.
     */
    public function isRegisteredUser(): bool
    {
        return !empty($this->customerUuid);
    }

    /**
     * Retourne l'identifiant actif.
     */
    public function activeIdentifier(): string
    {
        return $this->customerUuid ?? $this->sessionId;
    }

    /**
     * Vérifie si les identifiants sont égaux.
     */
    public function equals(self $other): bool
    {
        return $this->activeIdentifier() === $other->activeIdentifier();
    }
}
