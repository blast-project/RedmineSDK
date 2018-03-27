<?php

declare(strict_types=1);

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Tests\Unit;

use Blast\Redmine\SDK\Repository\IssueRepository;
use Blast\Redmine\SDK\Model\Issue;
use Blast\Redmine\SDK\Model\Project;
use Blast\Redmine\SDK\Model\JournalEntry;

class ResultTest extends RedmineTestCase
{
    public function test_hydrate()
    {
        $issueRepo = new IssueRepository($this->authConfig);
        $result = $issueRepo->findAll(['limit' => 1]);
        $firstIssue = $result[0];
        $freshFirstIssue = $issueRepo->find($firstIssue['id'], ['include' => 'journals'])->hydrate();

        $this->assertInstanceOf(Issue::class, $freshFirstIssue);
        $this->assertInstanceOf(Project::class, $freshFirstIssue->get('project'));
        $this->assertInstanceOf(JournalEntry::class, $freshFirstIssue->get('journals')[0]);
    }
}
