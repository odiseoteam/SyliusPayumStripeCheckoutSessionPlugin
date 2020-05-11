<?php

declare(strict_types=1);

namespace Prometee\SyliusPayumStripeCheckoutSessionPlugin\Provider;

use Sylius\Component\Core\Model\OrderInterface;

interface CustomerDetailsProviderInterface
{
    public function getCustomerDetails(OrderInterface $order): array;
}
