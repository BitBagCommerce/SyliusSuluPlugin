<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Renderer\Page;

use Psr\Log\LoggerInterface;
use Twig\Error\Error;
use Twig\Error\RuntimeError;

final class SuluPageRendererStrategy implements SuluPageRendererStrategyInterface
{
    public function __construct(
        private iterable $pageRenderers,
        private LoggerInterface $logger,
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
                $this->logger->error(sprintf(
                    '%s%s',
                    'Something goes wrong on page render. Error message : ',
                    $error->getMessage(),
                ));

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
