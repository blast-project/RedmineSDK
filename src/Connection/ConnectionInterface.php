<?php

/*
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Connection;

use GuzzleHttp\ClientInterface;

interface ConnectionInterface
{
    public function getBaseUri(): string;

    public function createHttpClient(): ClientInterface;

    public function getAuthHeaders(): array;
}
