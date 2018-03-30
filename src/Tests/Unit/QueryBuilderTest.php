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

use Blast\RedmineSDK\Query\QueryBuilder;
use Blast\RedmineSDK\Repository\IssueRepository;
use Blast\RedmineSDK\Model\JournalEntry;

class QueryBuilderTest extends RedmineTestCase
{
    public function test_query_limit()
    {
        $this->appendJsonResponse(200, 'find-all-limit-4.json');

        $limit = 4;
        $qb = new QueryBuilder();
        $qb->limit($limit);

        $issueRepo = new IssueRepository($this->authConfig);
        $issues = $issueRepo->findAll($qb->build())->hydrate();
        $this->assertEquals(count($issues), $limit);

        $uri = $this->mock->getLastRequest()->getUri();
        $expectedQuery = sprintf('limit=%s', $limit);
        $this->assertEquals($uri->getQuery(), $expectedQuery);
    }

    public function test_query_include()
    {
        $this->appendJsonResponse(200, 'find-issue-6226-with-journals.json');

        $qb = new QueryBuilder();
        $qb->include('journals');

        $issueRepo = new IssueRepository($this->authConfig);
        $issue = $issueRepo->find($this->issueId, $qb->build())->hydrate();
        $this->assertInstanceOf(JournalEntry::class, $issue->get('journals')[0]);

        $uri = $this->mock->getLastRequest()->getUri();
        $expectedQuery = 'include=journals';
        $this->assertEquals($uri->getQuery(), $expectedQuery);
    }

    public function test_query_where()
    {
        $this->appendJsonResponse(200, 'find-all-limit-4-project-11.json');

        $limit = 4;
        $qb = new QueryBuilder();
        $qb->whereEq('project_id', $this->projectId);
        $qb->limit($limit);

        $issueRepo = new IssueRepository($this->authConfig);
        $issues = $issueRepo->findAll($qb->build())->hydrate();
        $this->assertEquals($issues[0]->get('project')->get('id'), $this->projectId);

        $uri = $this->mock->getLastRequest()->getUri();
        $expectedQuery = sprintf('project_id=%s&limit=%s', $this->projectId, $limit);
        $this->assertEquals($uri->getQuery(), $expectedQuery);
    }

    public function test_query_sort()
    {
        $this->appendJsonResponse(200, 'find-all-limit-10-update_on.json');

        $limit = 10;
        $qb = new QueryBuilder();
        $qb->sortBy([['updated_on', 'desc']]);
        $qb->limit($limit);

        $issueRepo = new IssueRepository($this->authConfig);
        $issues = $issueRepo->findAll($qb->build())->hydrate();
        $this->assertEquals(count($issues), $limit);

        $uri = $this->mock->getLastRequest()->getUri();
        $expectedQuery = sprintf('sort=%s&limit=%s', urlencode('updated_on:desc'), $limit);
        $this->assertEquals($uri->getQuery(), $expectedQuery);
    }
}
