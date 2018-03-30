<?php

declare(strict_types=1);

/*
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Tests\Unit;

use Blast\RedmineSDK\Repository\IssueRepository;
use Blast\RedmineSDK\Model\Issue;

class RepositoryTest extends RedmineTestCase
{
    public function test_findAll_uri()
    {
        $this->appendJsonResponse(200, 'find-all-limit-10.json');
        $limit = 10;
        $issueRepo = new IssueRepository($this->authConfig);
        $result = $issueRepo->findAll(['limit'=> $limit]);

        $uri = $this->mock->getLastRequest()->getUri();
        $expectedPath = sprintf('/%s.%s', $issueRepo->getRoute(), $issueRepo->getFormat());
        $this->assertEquals($uri->getPath(), $expectedPath);
    }

    public function test_findById_uri()
    {
        $this->appendJsonResponse(200, 'find-issue-6226.json');
        $issueRepo = new IssueRepository($this->authConfig);
        $issue = $issueRepo->find($this->issueId);

        $uri = $this->mock->getLastRequest()->getUri();
        $expectedPath = sprintf('/%s/%s.%s', $issueRepo->getRoute(), $issue['id'], $issueRepo->getFormat());
        $this->assertEquals($uri->getPath(), $expectedPath);
    }

    public function test_findAll()
    {
        $this->appendJsonResponse(200, 'find-all-limit-10.json');
        $limit = 10;
        $issueRepo = new IssueRepository($this->authConfig);
        $result = $issueRepo->findAll(['limit'=> $limit]);

        $this->assertEquals(count($result), $limit);

        $uri = $this->mock->getLastRequest()->getUri();
        $expectedQuery = sprintf('limit=%s', $limit);
        $this->assertEquals($uri->getQuery(), $expectedQuery);
    }

    public function test_findById()
    {
        $this->appendJsonResponse(200, 'find-all-limit-1.json');
        $this->appendJsonResponse(200, 'find-issue-6226.json');
        $limit = 1;
        $issueRepo = new IssueRepository($this->authConfig);
        $result = $issueRepo->findAll(['limit' => $limit]);
        $firstIssue = $result[0];
        $freshFirstIssue = $issueRepo->find($firstIssue['id']);

        $this->assertEquals($freshFirstIssue['id'], $firstIssue['id']);

        $uri = $this->mock->getLastRequest()->getUri();
        $expectedPath = sprintf('/%s/%s.%s', $issueRepo->getRoute(), $freshFirstIssue['id'], $issueRepo->getFormat());
        $this->assertEquals($uri->getPath(), $expectedPath);
    }

    public function test_update()
    {
        $this->appendJsonResponse(200, 'find-issue-6226.json');
        $this->appendJsonResponse(200);

        $issueRepo = new IssueRepository($this->authConfig);
        $issue = $issueRepo->find($this->issueId)->hydrate();

        $result = $issueRepo->update($issue);
        $this->assertEquals($result->getResponse()->getStatusCode(), 200);
    }

    public function test_create()
    {
        $this->appendJsonResponse(200);
        $issueRepo = new IssueRepository($this->authConfig);

        $issue = new Issue();
        $issue->set('subject', 'my issue');
        $result = $issueRepo->create($issue);
        $this->assertEquals($result->getResponse()->getStatusCode(), 200);
    }
}
