<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewsApiService
{
    public function __construct(
        private ApiService $api,
        HttpClientInterface $client,
        ParameterBagInterface $parameterBagInterface,
    ) {
        $this->api
            ->setClient($client)
            ->setDomain('https://newsapi.org/v2')
            ->setKey($parameterBagInterface->get('news_api_key'));
    }

    public function getNews(
        string $country = 'us',
        string $category = 'science',
    ): object {
        return $this->api->request('top-headlines', [
            'country' => $country,
            'category' => $category,
        ]);
    }
}
