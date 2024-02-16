<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Renderer\Block;

use Twig\Error\Error;
use Twig\Error\RuntimeError;

final class SuluBlockRendererStrategy
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
