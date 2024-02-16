<?php

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
}
