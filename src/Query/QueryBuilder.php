<?php

/*
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Query;

class QueryBuilder
{
    protected $include = [];
    protected $equals = [];
    protected $limit = null;
    protected $sort = [];

    public function include($value): self
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        $this->include = $value;

        return $this;
    }

    /**
     * [sort description].
     * example : $qb->sort([['my_field' => 'desc'],['my_other_field' => 'asc']]).
     *
     * @param string|array $value
     */
    public function sortBy($value): self
    {
        if (!is_array($value)) {
            $value = [[$value, 'asc']];
        }
        $value = array_map(function ($item) {
            return sprintf('%s:%s', $item[0], $item[1]);
        }, $value);
        $this->sort = $value;

        return $this;
    }

    public function whereEq($field, $value): self
    {
        $this->equals[$field] = $value;

        return $this;
    }

    public function limit(int $value): self
    {
        $this->limit = $value;

        return $this;
    }

    public function build(): array
    {
        $query = [];

        if (!empty($this->equals)) {
            $query = array_merge($query, $this->equals);
        }

        if (!empty($this->include)) {
            $query = array_merge($query, ['include' => implode(',', $this->include)]);
        }

        if (!empty($this->sort)) {
            $query = array_merge($query, ['sort' => implode(',', $this->sort)]);
        }

        if (null !== $this->limit) {
            $query = array_merge($query, ['limit' => $this->limit]);
        }

        return $query;
    }
}
