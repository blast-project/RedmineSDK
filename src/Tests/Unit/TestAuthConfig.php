<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Blast\RedmineSDK\Config\AbstractAuthConfig;

class TestAuthConfig extends AbstractAuthConfig
{
    private $mock;

    public function __construct(MockHandler $mock)
    {
        $this->mock = $mock;
    }

    public function createHttpClient(): ClientInterface
    {
        return new Client([
          'base_uri' => $this->getBaseUri(),
          'handler'  => HandlerStack::create($this->mock),
        ]);
    }

    public function getBaseUri(): string
    {
        return 'https://redmine.example.org';
    }

    public function getBasicAuth(): string
    {
        return 'Basic ' . base64_encode(sprintf('%s:%s', 'login', 'password'));
    }

    public function getAuthHeaders(): array
    {
        return ['Authorization' => $this->getBasicAuth()];
    }
}
