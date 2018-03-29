<?php

declare(strict_types=1);

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Tests\Unit;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

abstract class RedmineTestCase extends TestCase
{
    protected $autConfig;
    protected $mock;
    protected $issueId;

    public function setUp()
    {
        $this->mock = new MockHandler();
        $this->authConfig = new TestAuthConfig($this->mock);
        $this->issueId = 6226;
        $this->projectId = 11;
    }

    public function getJsonFixture($filename)
    {
        return \file_get_contents(__DIR__ . '/../Resources/' . $filename);
    }

    public function appendJsonResponse(int $code, ?string $filename = null)
    {
        $this->mock->append($this->createJsonResponse($code, $filename));
    }

    public function createJsonResponse(int $code, ?string $filename = null)
    {
        return new Response($code,
      [
        'Content-Type' => 'application/json; charset=utf-8',
      ],
       ($filename == null ? null : $this->getJsonFixture($filename)));
    }
}
