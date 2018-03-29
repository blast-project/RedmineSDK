<?php

declare(strict_types=1);

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Tests\Unit;

use Blast\RedmineSDK\Repository\IssueRepository;
use Blast\RedmineSDK\Model\Issue;
use Blast\RedmineSDK\Model\Project;
use Blast\RedmineSDK\Model\JournalEntry;

class ResultTest extends RedmineTestCase
{
    public function test_hydrate()
    {
        $this->appendJsonResponse(200, 'find-all-limit-1.json');
        $this->appendJsonResponse(200, 'find-issue-6226-with-journals.json');

        $issueRepo = new IssueRepository($this->authConfig);
        $result = $issueRepo->findAll(['limit' => 1]);
        $firstIssue = $result[0];
        $freshFirstIssue = $issueRepo->find($firstIssue['id'], ['include' => 'journals'])->hydrate();

        $this->assertInstanceOf(Issue::class, $freshFirstIssue);
        $this->assertInstanceOf(Project::class, $freshFirstIssue->get('project'));
        $this->assertInstanceOf(JournalEntry::class, $freshFirstIssue->get('journals')[0]);
    }
}
