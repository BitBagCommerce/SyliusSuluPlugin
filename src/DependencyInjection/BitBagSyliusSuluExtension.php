<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\DependencyInjection;

use BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRenderStrategyInterface;
use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRenderStrategyInterface;
use Sylius\Bundle\CoreBundle\DependencyInjection\PrependDoctrineMigrationsTrait;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class BitBagSyliusSuluExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    use PrependDoctrineMigrationsTrait;

    /** @psalm-suppress UnusedVariable */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));

        $loader->load('services.xml');

        $this->RegisterPageRenderers($container);
        $this->RegisterBlockRenderers($container);
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->prependDoctrineMigrations($container);
    }

    protected function getMigrationsNamespace(): string
    {
        return 'DoctrineMigrations';
    }

    protected function getMigrationsDirectory(): string
    {
        return '@BitBagSyliusSuluPlugin/Migrations';
    }

    protected function getNamespacesOfMigrationsExecutedBefore(): array
    {
        return [
            'Sylius\Bundle\CoreBundle\Migrations',
        ];
    }

    private function RegisterPageRenderers(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(SuluPageRenderStrategyInterface::class)
            ->addTag('bitbag.sylius_sulu_plugin.strategy.page_renderer')
        ;
    }

    private function RegisterBlockRenderers(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(SuluBlockRenderStrategyInterface::class)
            ->addTag('bitbag.sylius_sulu_plugin.strategy.block_renderer')
        ;
    }
}
