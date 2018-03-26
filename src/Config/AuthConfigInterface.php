<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Config;

interface AuthConfigInterface
{
    public function getHeaders(): array;

    public function applyHeaders(array $headers): array;
}
