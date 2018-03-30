<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

abstract class AbstractConnection implements ConnectionInterface
{
    public function createHttpClient(): ClientInterface
    {
        return new Client(['base_uri' => $this->getBaseUri()]);
    }
}
