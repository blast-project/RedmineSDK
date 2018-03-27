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

class RepositoryTest extends RedmineTestCase
{
    public function test_findAll()
    {
        $issueRepo = new IssueRepository($this->authConfig);
        $result = $issueRepo->findAll(['limit'=> 10]);

        $this->assertEquals(count($result), 10);
    }

    public function test_findById()
    {
        $issueRepo = new IssueRepository($this->authConfig);
        $result = $issueRepo->findAll(['limit' => 1]);
        $firstIssue = $result[0];
        $freshFirstIssue = $issueRepo->find($firstIssue['id']);

        $this->assertEquals($freshFirstIssue['id'], $firstIssue['id']);
    }

    public function test_update()
    {
        $issueRepo = new IssueRepository($this->authConfig);
        $issue = $issueRepo->find($this->issueId)->hydrate();

        $result = $issueRepo->update($issue);
        $this->assertEquals($result->getResponse()->getStatusCode(), 200);
    }
}
