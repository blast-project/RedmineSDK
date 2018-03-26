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

abstract class Result
{
    protected $request;
    protected $response;
    protected $data;
    protected $dataKey;
    protected $options = [];

    public static function fromResponse(ResponseInterface $response, string $dataKey = 'data', array $options = [])
    {
        $result = new static();
        $result->response = $response;
        $result->dataKey = $dataKey;
        $result->options = $options;
        $result->data = $result->extractData((string) $response->getBody());

        return $result;
    }

    abstract protected function extractData($data);

    public function getData()
    {
        return $this->data[$this->dataKey];
    }

    public function geTotalCount()
    {
        return $this->data['total_count'];
    }

    public function getOffset()
    {
        return $this->data['offset'];
    }

    public function getLimit()
    {
        return $this->data['limit'];
    }

    public function getResponse()
    {
        return $this->response;
    }
}
