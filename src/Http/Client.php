<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Http;

use Blast\Redmine\SDK\Config\AuthConfigInterface;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Blast\Redmine\SDK\Http\Result\ResultFactory;
use Blast\Redmine\SDK\Http\Result\Result;

class Client
{
    private $authConfig;
    private $format = 'json';
    private $baseUri = '';
    private $route = '';
    private $dataKey = 'data';
    private $httpClient;

    public function __construct(AuthConfigInterface $authConfig)
    {
        $this->authConfig = $authConfig;
        $this->baseUri = $authConfig->getBaseUri();
        $this->httpClient = new GuzzleClient([
          'base_uri' => $this->baseUri,
          'timeout'  => 2.0,
        ]);
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFormat(?string $format)
    {
        $this->format = $format;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function setBaseUri(string $uri)
    {
        $this->baseUri = $uri;
    }

    public function setRoute(string $route)
    {
        $this->route = $route;
    }
    public function getDataKey(): string
    {
        return $this->dataKey;
    }

    public function setDataKey(string $key)
    {
        $this->dataKey = $key;
    }

    public function buildUri(?string $route = null): string
    {
        $uri = $this->route;

        if(null !== $route){
          $uri = $uri .'/'.$route;
        }
        if(null !== $this->format){
          $uri = $uri .'.'.$this->format;
        }
        return $uri;
    }

    public function get($route, array $query = [], ?string $dataKey = null): Result {

      $options = [
        'headers' => [],
        'query' => $query
      ];

      $options['headers'] = $this->authConfig->applyHeaders($options['headers']);

      $response = $this->httpClient->request('GET', $this->buildUri($route), $options);
      return ResultFactory::fromResponse($this->format, $dataKey, $response);
    }
}
