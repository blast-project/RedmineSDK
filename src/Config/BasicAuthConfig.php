<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Config;

class BasicAuthConfig extends AbstractAuthConfig
{
    private $baseUri;
    private $login;
    private $password;

    public function __construct($baseUri, $login, $password)
    {
        $this->baseUri = $baseUri;
        $this->login = $login;
        $this->password = $password;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getBasicAuth(): string
    {
        return 'Basic ' . base64_encode(sprintf('%s:%s', $this->login, $this->password));
    }

    public function getAuthHeaders(): array
    {
      return ['Authorization' => $this->getBasicAuth()];
    }

}
