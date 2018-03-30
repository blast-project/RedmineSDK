<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Model;

class Project extends RedmineModel
{
    protected $id;
    protected $name;
    protected $identifier;
    protected $description;
    protected $status;
    protected $createdOn;
    protected $udpatedOn;
    protected $parent;

    public function isFulfilled(): bool
    {
        return parent::isFulfilled() && $this->has('identifier');
    }

    protected function hydrateValue($value, ?string $name = null)
    {
        if (!isset($name)) {
            return parent::hydrateValue($value, $name);
        }

        if ($name != 'parent') {
            return parent::hydrateValue($value, $name);
        }

        if (!is_array($value)) {
            return $value;
        }

        return self::create($value);
    }
}
