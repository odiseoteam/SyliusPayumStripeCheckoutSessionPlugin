<?php

declare(strict_types=1);

namespace Prometee\SyliusPayumStripeCheckoutSessionPlugin\Provider;

use Sylius\Component\Core\Model\OrderInterface;

interface PaymentDetailsProviderInterface extends DetailsProviderInterface
{
    public function getDetails(OrderInterface $order): array;
}
