<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Renderer\Page;

use Twig\Error\Error;
use Twig\Error\RuntimeError;

final class SuluPageRendererStrategy implements SuluPageRendererStrategyInterface
{
    public function __construct(
        private iterable $pageRenderers,
    ) {
    }

    public function renderPage(array $page): string
    {
        /** @var SuluPageRenderStrategyInterface $pageRenderer */
        foreach ($this->pageRenderers as $pageRenderer) {
            if (!$pageRenderer->support($page)) {
                continue;
            }

            try {
                $content = $pageRenderer->render($page);

                return $content;
            } catch (Error $error) {
                return '';
            }
        }

        $type = $page['template'] ?? '---';

        throw new RuntimeError(
            sprintf(
                'Page renderer for page %s was not found',
                $type,
            ),
        );
    }
}
