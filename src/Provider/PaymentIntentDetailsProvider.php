<?php

declare(strict_types=1);

namespace Prometee\SyliusPayumStripeCheckoutSessionPlugin\Provider;

use Sylius\Component\Core\Model\OrderInterface;

final class PaymentIntentDetailsProvider implements DetailsProviderInterface
{
    /** @var PaymentMethodTypesProviderInterface */
    private $paymentMethodTypesProvider;

    public function __construct(
        PaymentMethodTypesProviderInterface $paymentMethodTypesProvider
    ) {
        $this->paymentMethodTypesProvider = $paymentMethodTypesProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getDetails(OrderInterface $order): array
    {
        $details = [
            'amount' => $order->getTotal(),
            'currency' => $order->getCurrencyCode(),
        ];

        $details['payment_method_types'] = $this->paymentMethodTypesProvider->getPaymentMethodTypes($order);

        return $details;
    }
}
