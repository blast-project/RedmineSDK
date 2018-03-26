<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Repository;

use Blast\Redmine\SDK\Http\Client as HttpClient;
use Blast\Redmine\SDK\Config\AuthConfigInterface;

abstract class AbstractRepository
{
    public function __construct(AuthConfigInterface $config)
    {
        $this->client = new HttpClient($config);
        $this->client->setRoute($this->getRoute());
        $this->client->setDataKey($this->getDataKey());
    }

    public function findAll()
    {
        $query = [
        'limit' => '100',
      ];

        return $this->client->get($query);
    }

    public function find($id)
    {
    }

    abstract public function getRoute(): string;

    protected function getDataKey(): string
    {
        return preg_replace('!^(.*/)!', '', $this->getRoute());
    }
}
