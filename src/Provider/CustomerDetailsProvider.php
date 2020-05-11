<?php

declare(strict_types=1);

namespace Prometee\SyliusPayumStripeCheckoutSessionPlugin\Provider;

use Prometee\SyliusPayumStripeCheckoutSessionPlugin\Entity\StripeIdAwareInterface;
use Sylius\Component\Core\Model\AddressInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;

final class CustomerDetailsProvider implements CustomerDetailsProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCustomerDetails(OrderInterface $order): array
    {
        $customer = $order->getCustomer();
        if (!$customer instanceof CustomerInterface) {
            return [];
        }

        $customerDetails = [
            'name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'phone' => $customer->getPhoneNumber(),
        ];

        $billingAddress = $order->getBillingAddress();
        if ($billingAddress) {
            $customerDetails['address'] = $this->getAddressDetails($billingAddress);

            if (null === $customerDetails['name']) {
                $customerDetails['name'] = $billingAddress->getFullName();
            }

            if (null === $customerDetails['phone']) {
                $customerDetails['phone'] = $billingAddress->getPhoneNumber();
            }
        }

        $shippingAddress = $order->getShippingAddress();
        if ($shippingAddress) {
            $customerDetails['shipping'] = [
                'address' => $this->getAddressDetails($shippingAddress),
                'name' => $shippingAddress->getFullName(),
                'phone' => $shippingAddress->getPhoneNumber(),
            ];
        }

        if ($customer instanceof StripeIdAwareInterface && $customer->getStripeId()) {
            $customerDetails['stripe_id'] = $customer->getStripeId();
        }

        return $customerDetails;
    }

    private function getAddressDetails(AddressInterface $address): array
    {
        return [
            'line1' => $address->getStreet(),
            'city' => $address->getCity(),
            'country' => $address->getCountryCode(),
            'postal_code' => $address->getPostcode(),
            'state' => $address->getProvinceName() ?: $address->getProvinceCode(),
        ];
    }
}
