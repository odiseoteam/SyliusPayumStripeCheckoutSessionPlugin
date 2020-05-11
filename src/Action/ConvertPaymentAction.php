<?php

declare(strict_types=1);

namespace Prometee\SyliusPayumStripeCheckoutSessionPlugin\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\Convert;
use Prometee\SyliusPayumStripeCheckoutSessionPlugin\Provider\DetailsProviderInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentInterface;

final class ConvertPaymentAction implements ActionInterface
{
    /** @var DetailsProviderInterface */
    private $detailsProvider;

    public function __construct(DetailsProviderInterface $detailsProvider)
    {
        $this->detailsProvider = $detailsProvider;
    }

    /**
     * {@inheritdoc}
     *
     * @param Convert $request
     */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();

        /** @var ArrayObject $details */
        $details = ArrayObject::ensureArrayObject($payment->getDetails());

        if (false === $details->offsetExists('id')) {
            /** @var OrderInterface $order */
            $order = $payment->getOrder();

            $details = $this->detailsProvider->getDetails($order);
        }

        $request->setResult((array) $details);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request): bool
    {
        return
            $request instanceof Convert &&
            $request->getSource() instanceof PaymentInterface &&
            $request->getTo() === 'array'
        ;
    }
}
