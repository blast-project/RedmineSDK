<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Model;

class IssueCategory extends RedmineModel
{
    protected $id;
    protected $name;
    protected $project;
    protected $assigned_to;

    protected function hydrateValue($value, ?string $name = null)
    {
        switch ($name) {
            case 'project':
                return Project::create($value);
            case 'assignedTo':
                return User::create($value);
            default:
                return parent::hydrateValue($value, $name);
        }
    }
}
