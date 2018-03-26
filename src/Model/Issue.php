<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Model;

class Issue
{
    protected $id;
    protected $project;
    protected $tracker;
    protected $status;
    protected $priority;
    protected $author;
    protected $subject;
    protected $description;
    protected $doneRatio;
    protected $customFields;
    protected $createdOn;
    protected $updatedOn;
    protected $assignedTo;
    protected $startDate;
    protected $dueDate;
    protected $estimatedHours;
    protected $parent;
}
