<?php

/*
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Model;

class TimeEntry extends RedmineModel
{
    protected $id;
    protected $project;
    protected $issue;
    protected $user;
    protected $activity;
    protected $hours;
    protected $comments;
    protected $spentOn;
    protected $createdOn;
    protected $updatedOn;

    public function __toString(): string
    {
        return $this->hours . ' (' . $this->activity['name'] . ' | ' . $this->project['name'] . ')';
    }

    protected function hydrateValue($value, ?string $name = null)
    {
        if (!$this->isElligibleToSpecialHydration($value, $name)) {
            return $value;
        }

        switch ($name) {
            case 'project':
                return Project::create($value);
            case 'issue':
                return Issue::create($value);
            case 'user':
                return User::create($value);
            case 'activity':
                return Activity::create($value);
        }

        return $value;
    }
}
