<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Model;

class User extends RedmineModel
{
    protected $id;
    protected $login;
    protected $name;
    protected $firstname;
    protected $lastname;
    protected $mail;
    protected $apiKey;
    protected $status;
    protected $createdOn;
    protected $lastLoginOn;

    public function __toString(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
