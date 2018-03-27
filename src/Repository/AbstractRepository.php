<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Repository;

use GuzzleHttp\Client as GuzzleClient;
use Blast\Redmine\SDK\Config\AuthConfigInterface;
use Blast\Redmine\SDK\Http\Result\ResultFactory;
use Blast\Redmine\SDK\Model\RedmineModel;

abstract class AbstractRepository
{
    protected $client;
    protected $config;
    protected $bodyKey;
    protected $defaultCollectionQuery = [];
    protected $defaultObjectQuery = [];

    public function __construct(AuthConfigInterface $config)
    {
        $this->config = $config;
        $this->client = new GuzzleClient([
          'base_uri' => $config->getBaseUri(),
        ]);
        $this->bodyKey = $this->getBodyKeyByFormat();
    }

    /**
     * @param array $query
     *
     * @return Result
     */
    public function findAll(array $query = [])
    {
        $uri = sprintf('%s.%s', $this->getRoute(), $this->getFormat());

        return $this->sendGetForCollection($uri, [], $query);
    }

    /**
     * @param mixed $id
     * @param array $query
     *
     * @return Result
     */
    public function find($id, array $query = [])
    {
        $uri = sprintf('%s/%s.%s', $this->getRoute(), $id, $this->getFormat());

        return $this->sendGetForOne($uri, [], $query);
    }

    /**
     * @param RedmineModel $model [description]
     *
     * @return [type] [description]
     */
    public function create(RedmineModel $model)
    {
        $uri = sprintf('%s.%s', $this->getRoute(), $this->getFormat());

        return $this->sendPost($uri, [], $model->toDTO());
    }

    /**
     * @param RedmineModel $model [description]
     *
     * @return [type] [description]
     */
    public function update(RedmineModel $model)
    {
        $uri = sprintf('%s/%s.%s', $this->getRoute(), $model->get('id'), $this->getFormat());
        return $this->sendPut($uri, [], $model->toDTO());
    }

    /**
     * @param string $uri
     * @param array  $headers
     * @param array  $query
     *
     * @return Result
     */
    protected function sendGetForCollection(string $uri, array $headers, array $query)
    {
        $headers = array_merge($this->config->getAuthHeaders(), $headers);
        $query = array_merge($this->defaultCollectionQuery, $query);

        $response = $this->client->request('GET', $uri, [
        'headers' => $headers,
        'query'   => $query,
      ]);

        $result = ResultFactory::fromResponse($this->getFormat(), $this->getCollectionDataKey(), $response, true);
        $result->setModelClass($this->getModelClass());

        return $result;
    }

    /**
     * @param string $uri
     * @param array  $headers
     * @param array  $query
     *
     * @return Result
     */
    protected function sendGetForOne(string $uri, array $headers, array $query)
    {
        $headers = array_merge($this->config->getAuthHeaders(), $headers);
        $query = array_merge($this->defaultObjectQuery, $query);

        $response = $this->client->request('GET', $uri, [
        'headers' => $headers,
        'query'   => $query,
      ]);

        $result = ResultFactory::fromResponse($this->getFormat(), $this->getObjectDataKey(), $response);
        $result->setModelClass($this->getModelClass());

        return $result;
    }

    protected function sendPost(string $uri, array $headers, array $data)
    {
        $headers = array_merge($this->config->getAuthHeaders(), $headers);
        $options = [
          'headers'        => $headers,
          $this->bodyKey   => [$this->getObjectDataKey() => $data],
        ];
        $response = $this->client->request('POST', $uri, $options);

        $result = ResultFactory::fromResponse($this->getFormat(), $this->getObjectDataKey(), $response);

        return $result;
    }

    protected function sendPut(string $uri, array $headers, array $data)
    {
        $headers = array_merge($this->config->getAuthHeaders(), $headers);
        $options = [
          'headers'        => $headers,
          $this->bodyKey   => [$this->getObjectDataKey() => $data],
        ];
        $response = $this->client->request('PUT', $uri, $options);
        $result = ResultFactory::fromResponse($this->getFormat(), $this->getObjectDataKey(), $response);

        return $result;
    }

    abstract protected function getFormat(): string;

    abstract protected function getRoute(): string;

    abstract protected function getModelClass(): string;

    abstract protected function getObjectDataKey(): string;

    abstract protected function getCollectionDataKey(): string;

    protected function getBodyKeyByFormat()
    {
        return $this->getFormat() == 'json' ? 'json' : 'body';
    }
}
