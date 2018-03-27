<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Model;

class Issue extends RedmineModel
{
    protected $id;
    protected $project;
    protected $tracker;
    protected $status;
    protected $priority;
    protected $author;
    protected $assignedTo;
    protected $category;
    protected $parent;
    protected $subject;
    protected $description;
    protected $startDate;
    protected $dueDate;
    protected $doneRatio;
    protected $estimatedHours;
    protected $totalEstimatedHours;
    protected $spentHours;
    protected $totalSpentHours;
    protected $customFields = [];
    protected $createdOn;
    protected $updatedOn;
    protected $relations = [];
    protected $attachments = [];
    protected $journals = [];

    protected function hydrateValue($value, ?string $name = null)
    {
        switch ($name) {
          case 'parent':
              return self::create($value);
          case 'assignedTo':
          case 'author':
              return User::create($value);
          case 'project':
              return Project::create($value);
          case 'status':
              return IssueStatus::create($value);
          case 'tracker':
              return Tracker::create($value);
          case 'priority':
              return IssuePriority::create($value);
          case 'customFields':
              return CustomField::createList($value);
          case 'relations':
              return IssueRelation::createList($value);
          case 'attachments':
              return Attachment::createList($value);
          case 'journals':
              return JournalEntry::createList($value);
          default:
            return parent::hydrateValue($value, $name);
      }
    }
}
