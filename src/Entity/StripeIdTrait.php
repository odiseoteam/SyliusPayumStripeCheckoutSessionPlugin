<?php

declare(strict_types=1);

namespace Prometee\SyliusPayumStripeCheckoutSessionPlugin\Entity;

trait StripeIdTrait
{
    /** @var string */
    protected $stripeId;

    public function getStripeId(): ?string
    {
        return $this->stripeId;
    }

    public function setStripeId(?string $stripeId): void
    {
        $this->stripeId = $stripeId;
    }
}
