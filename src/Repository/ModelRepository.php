<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Repository;

use Blast\Redmine\SDK\Config\AuthConfigInterface;

class ModelRepository extends AbstractRepository
{
    private $route;

    public function __construct(AuthConfigInterface $config, $route)
    {
        $this->route = $route;
        parent::__construct($config);
    }
    public function getRoute(): string
    {
        return $this->route;
    }
}
