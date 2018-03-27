<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Http\Result;

use Psr\Http\Message\ResponseInterface;
use Iterator;
use ArrayAccess;
use Countable;

abstract class Result implements Iterator, ArrayAccess, Countable
{
    protected $response;
    protected $rawResult;
    protected $data;
    protected $dataKey;
    protected $options = [];
    protected $treatAsCollection;
    protected $modelClass;

    private function __construct()
    {
    }

    public static function fromResponse(ResponseInterface $response, string $dataKey = 'data', array $options = [])
    {
        $r = new static();
        $r->response = $response;
        $r->dataKey = $dataKey;
        $r->options = $options;
        $r->rawResult = $r->extractData((string) $response->getBody());
        $r->data = $r->rawResult[$r->dataKey];
        $r->treatAsCollection = $options['collection'] ?? false;

        return $r;
    }

    abstract protected function extractData($data);

    public function getData()
    {
        return $this->data;
    }

    public function hydrate()
    {
        $data = null;

        if (null === $this->getModelClass()) {
            return $this;
        }
        if ($this->treatAsCollection) {
            $data = [];
            foreach ($this as $item) {
                $data[] = $this->getModelClass()::fromResult($this);
            }
        } else {
            $data = $this->getModelClass()::fromResult($this);
        }
        return $data;
    }

    public function geTotalCount()
    {
        return $this->rawResult['total_count'];
    }

    public function getOffset()
    {
        return $this->rawResult['offset'];
    }

    public function getLimit()
    {
        return $this->rawResult['limit'];
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setModelClass(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    public function getModelClass()
    {
        return $this->modelClass;
    }

    public function rewind()
    {
        reset($this->data);
    }

    public function current()
    {
        return current($this->data);
    }

    public function key()
    {
        return key($this->data);
    }

    public function next()
    {
        return next($this->data);
    }

    public function valid()
    {
        return false !== current($this->data);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function count()
    {
        return count($this->data);
    }
}
