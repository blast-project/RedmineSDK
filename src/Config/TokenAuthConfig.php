<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Config;

class BasicAuthConfig  extends AbstractAuthConfig
{
    private $baseUri;
    private $token;

    public function __construct($baseUri, $token)
    {
        $this->baseUri = $baseUri;
        $this->token = $token;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getAuthHeaders(): array
    {
        return ['X-Redmine-API-Key' => $this->getToken()];
    }
}
