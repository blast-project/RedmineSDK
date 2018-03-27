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

use Blast\RedmineSDK\Query\QueryBuilder;
use Blast\RedmineSDK\Repository\IssueRepository;
use Blast\RedmineSDK\Model\JournalEntry;

class QueryBuilderTest extends RedmineTestCase
{
    public function test_query_limit()
    {
        $limit = 4;
        $qb = new QueryBuilder();
        $qb->limit($limit);

        $issueRepo = new IssueRepository($this->authConfig);
        $issues = $issueRepo->findAll($qb->build())->hydrate();
        $this->assertEquals(count($issues), $limit);
    }

    public function test_query_include()
    {
        $qb = new QueryBuilder();
        $qb->include('journals');

        $issueRepo = new IssueRepository($this->authConfig);
        $issue = $issueRepo->find($this->issueId, $qb->build())->hydrate();
        $this->assertInstanceOf(JournalEntry::class, $issue->get('journals')[0]);
    }

    public function test_query_where()
    {
        $limit = 4;
        $qb = new QueryBuilder();
        $qb->whereEq('project_id', $this->projectId);
        $qb->limit($limit);

        $issueRepo = new IssueRepository($this->authConfig);
        $issues = $issueRepo->findAll($qb->build())->hydrate();
        $this->assertEquals($issues[0]->get('project')->get('id'), $this->projectId);
    }

    public function test_query_sort()
    {
        $limit = 4;
        $qb = new QueryBuilder();
        $qb->sortBy([['updated_on', 'desc']]);
        $qb->limit($limit);

        $issueRepo = new IssueRepository($this->authConfig);
        $issues = $issueRepo->findAll($qb->build())->hydrate();
        $this->assertEquals(count($issues), $limit);
    }
}
