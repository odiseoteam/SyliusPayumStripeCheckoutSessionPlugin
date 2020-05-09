<?php

declare(strict_types=1);

namespace Prometee\SyliusPayumStripeCheckoutSessionPlugin\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PrometeeSyliusPayumStripeCheckoutSessionExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configs = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $container->setParameter(
            'payum.template.pay',
            $configs['payum_template_pay']
        );

        $container->setParameter(
            'prometee_sylius_payum_stripe_checkout_session.line_item_image.imagine_filter',
            $configs['line_item_image']['imagine_filter']
        );
        $container->setParameter(
            'prometee_sylius_payum_stripe_checkout_session.line_item_image.fallback_image',
            $configs['line_item_image']['fallback_image']
        );

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(dirname(__DIR__) . '/Resources/config')
        );
        $loader->load('services.yaml');
    }
}
