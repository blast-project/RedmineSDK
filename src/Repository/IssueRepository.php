<?php

/*
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Repository;

use Blast\RedmineSDK\Model\Issue;
use Blast\RedmineSDK\Query\QueryBuilder;

class IssueRepository extends Repository
{
    public function findIssuesByPojectId(int $projectId)
    {
        $qb = new QueryBuilder();
        $qb->whereEq('project_id', $projectId);

        return $this->findAll($qb);
    }

    public function findRelations(Issue $issue)
    {
        $uri = sprintf('%s/%s/relations.json', $this->getRoute(), $issue->get('id'));

        return $this->sendGetForCollection($uri, [], $query);
    }

    public function getFormat(): string
    {
        return 'json';
    }

    public function getRoute(): string
    {
        return 'issues';
    }

    protected function getModelClass(): string
    {
        return Issue::class;
    }

    protected function getObjectDataKey(): string
    {
        return 'issue';
    }

    protected function getCollectionDataKey(): string
    {
        return 'issues';
    }
}
