<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\ApiClient;

interface SuluApiClientInterface
{
    public function fetchCmsContent(string $url): array;
}
