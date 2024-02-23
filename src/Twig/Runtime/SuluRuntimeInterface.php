<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

interface SuluRuntimeInterface extends RuntimeExtensionInterface
{
    public function getSuluPage(string $id): array;

    public function renderSuluPage(string $id): string;

    public function renderSuluBlocks(array $blocks): string;

    public function renderSuluBlocksWithType(array $blocks, string $type): string;

    public function renderSuluBlockWithType(array $blocks, string $type): string;

    public function hasSuluBlock(array $page, string $type): bool;
}
