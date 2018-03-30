<?php

/*
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Model;

class JournalEntry extends RedmineModel
{
    protected $id;
    protected $user;
    protected $notes;
    protected $createsOn;
    protected $details = [];

    protected function hydrateValue($value, ?string $name = null)
    {
        switch ($name) {
            case 'user':
                return User::create($value);
            default:
                return parent::hydrateValue($value, $name);
        }
    }
}
