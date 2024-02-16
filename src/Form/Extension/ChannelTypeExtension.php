<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Form\Extension;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

final class ChannelTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('suluUseLocalizedUrls', CheckboxType::class, [
                'label' => 'bitbag.sulu_plugin.use_localized_url',
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [
            ChannelType::class,
        ];
    }
}
