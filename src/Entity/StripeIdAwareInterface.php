<?php

declare(strict_types=1);

namespace Prometee\SyliusPayumStripeCheckoutSessionPlugin\Entity;

interface StripeIdAwareInterface
{
    public function getStripeId(): ?string;

    public function setStripeId(?string $stripeId): void;
}
