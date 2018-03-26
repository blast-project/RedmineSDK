<?php

declare(strict_types=1);

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Blast\Redmine\SDK\Config\BasicAuthConfig;

class QueryBuilderTest extends TestCase
{
    private $autConfig;

    public function setUp()
    {
        $parameters = Yaml::parseFile(__DIR__ . '/../Resources/parameters.yml');
        $configData = $parameters['redmine_sdk'];
        $this->authConfig = new BasicAuthConfig(
          $configData['base_uri'], $configData['login'], $configData['password']);
    }

    public function testQuery()
    {
        //$qb = new QueryBuilder();


    }
}
