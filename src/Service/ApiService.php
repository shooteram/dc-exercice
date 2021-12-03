<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
    private CacheInterface $cache;
    private string $domain;
    private ?string $key;

    public function __construct(
        private HttpClientInterface $httpClientInterface,
    ) {
        $this->cache = new FilesystemAdapter();
    }

    public function setClient(HttpClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function setDomain(string $domain): self
    {
        // ensure domain has trailing slash
        if (substr($domain, -1, 1) !== '/') {
            $domain = "$domain/";
        }

        $this->domain = $domain;

        return $this;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    private function url(string $path, array $parameters = []): string
    {
        $query = '';
        if ($parameters) $query = sprintf('?%s', http_build_query($parameters));

        return sprintf('%s%s%s', $this->domain, $path, $query);
    }

    public function request(
        string $url,
        array $parameters = [],
        string $method = Request::METHOD_GET,
    ): mixed {
        if (!$this->client) {
            throw new \Exception(
                'use the public function "setClient" before continuing'
            );
        }

        $url = $this->url($url, $parameters);

        $response = $this->cache->get(
            hash('sha256', sprintf('%s%s', $url, $this->key ?? '')),
            function (ItemInterface $item) use ($method, $url) {
                $item->expiresAfter(3600);

                $options = ['headers' => ['accept' => 'application/json']];
                if ($this->key) {
                    $options['headers']['x-api-key'] = $this->key;
                }

                return $this->httpClientInterface
                    ->request($method, $url, $options)
                    ->getContent(true);
            }
        );

        return json_decode($response);
    }
}
