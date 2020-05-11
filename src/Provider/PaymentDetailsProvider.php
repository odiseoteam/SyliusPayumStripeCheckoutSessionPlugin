<?php

declare(strict_types=1);

namespace Prometee\SyliusPayumStripeCheckoutSessionPlugin\Provider;

use Sylius\Component\Core\Model\OrderInterface;

final class PaymentDetailsProvider implements PaymentDetailsProviderInterface
{
    /** @var PaymentMethodTypesProviderInterface */
    private $paymentMethodTypesProvider;

    /** @var CustomerDetailsProviderInterface */
    private $customerDetailsProvider;

    public function __construct(
        PaymentMethodTypesProviderInterface $paymentMethodTypesProvider,
        CustomerDetailsProviderInterface $customerDetailsProvider
    ) {
        $this->paymentMethodTypesProvider = $paymentMethodTypesProvider;
        $this->customerDetailsProvider = $customerDetailsProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getDetails(OrderInterface $order): array
    {
        $details = [
            'metadata' => [
                'order_id' => $order->getId(),
            ],
            'amount' => $order->getTotal(),
            'currency' => $order->getCurrencyCode(),
            'customer' => $this->customerDetailsProvider->getCustomerDetails($order),
        ];

        $details['payment_method_types'] = $this->paymentMethodTypesProvider->getPaymentMethodTypes($order);

        return $details;
    }
}
