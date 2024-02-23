<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Renderer\Block;

use Twig\Error\Error;
use Twig\Error\RuntimeError;

final class SuluBlockRendererStrategy implements SuluBlockRendererStrategyInterface
{
    public function __construct(
        private iterable $blockRenderers,
    ) {
    }

    public function renderBlock(array $blockData): string
    {
        /** @var SuluBlockRenderStrategyInterface $blockRenderer */
        foreach ($this->blockRenderers as $blockRenderer) {
            if (!$blockRenderer->support($blockData)) {
                continue;
            }

            try {
                $content = $blockRenderer->render($blockData);

                return $content;
            } catch (Error $error) {
                return '';
            }
        }

        $type = $blockData['type'] ?? '---';

        throw new RuntimeError(
            sprintf(
                'Block renderer for block %s was not found',
                $type,
            ),
        );
    }
}
