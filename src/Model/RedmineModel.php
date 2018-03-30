<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Model;

use Blast\RedmineSDK\Http\Result\Result;
use Blast\RedmineSDK\Util\StringConverter;

class RedmineModel
{
    public function __construct()
    {
    }

    public static function fromResult(Result $result)
    {
        return self::create($result->getData());
    }

    public static function create(array $data)
    {
        $model = new static();
        $model->hydrate($data);

        return $model;
    }

    public static function createList(array $data)
    {
        $list = [];
        foreach ($data as $item) {
            $list[] = self::create($item);
        }

        return $list;
    }

    public function hydrate(array $data): void
    {
        $rc = new \ReflectionClass($this);
        $converter = new StringConverter();

        foreach ($data as $name => $value) {
            $name = $converter->fromSnakeCaseToCamelCase($name);
            if (!$rc->hasProperty($name)) {
                continue;
            }

            $this->$name = $this->hydrateValue($value, $name);
        }
    }

    public function toArray(bool $deep = false): array
    {
        $rc = new \ReflectionClass($this);
        $data = [];

        foreach ($rc->getProperties() as $prop) {
            $field = $prop->getName();

            if ($deep && is_object($this->$field) && method_exists($this->$field, 'toArray')) {
                $data[$field] = $this->$field->toArray($deep);
                continue;
            }

            $data[$field] = $this->$field;
        }

        return $data;
    }

    public function toDTO(): array
    {
        $rc = new \ReflectionClass($this);
        $converter = new StringConverter();
        $data = [];

        foreach ($rc->getProperties() as $prop) {
            if($prop->isPrivate()){
              continue;
            }
            $field =   $prop->getName();
            $fieldKey = $converter->fromCamelCaseToSnakeCase($field);

            if (is_object($this->$field)) {
                $data[$fieldKey . '_id'] = $this->$field->get('id');
                continue;
            }
            if ($field == 'customFields') {
                $data[$fieldKey] = [];
                foreach($this->$field as $customField){
                  $data[$fieldKey][] = [
                    'id' =>  $customField->get('id'),
                    'value' => $customField->get('value')];
                }
                continue;
            }

            $data[$fieldKey] = $this->$field;
        }

        return $data;
    }

    /**
     * Function hydrateValue
     * Entity::hydrateValue() is dummy, extend it if needed.
     *
     * @param mixed       $value
     * @param string|null $name
     *
     * @return mixed
     */
    protected function hydrateValue($value, ?string $name = null)
    {
        return $value;
    }

    /**
     * Function that returns the content of a property.
     *
     * @param string $property
     *
     * @return mixed Depending on the data stored...
     */
    public function get(string $property)
    {
        if (!$this->hasProperty($property)) {
            return null;
        }

        return $this->$property;
    }

    /**
     * Function that checks if a property has been defined.
     *
     * @param string $property
     * @param bool
     */
    public function has(string $property): bool
    {
        if (!$this->hasProperty($property)) {
            return false;
        }

        return isset($this->$property);
    }

    /**
     * Function that sets the content to a property of the current object.
     *
     * @param string $property
     * @param mixed  $value
     */
    public function set(string $property, $value): void
    {
        if (!$this->hasProperty($property)) {
            return;
        }
        $this->$property = $value;

        return;
    }

    protected function hasProperty(string $property)
    {
        $rc = new \ReflectionClass($this);

        return $rc->hasProperty($property);
    }

    public function __call($m, $p)
    {
        $v = strtolower(substr($m, 3));
        if (!strncasecmp($m, 'get', 3)) {
            return $this->get($v);
        }
        if (!strncasecmp($m, 'set', 3)) {
            $this->set($v, $p[0]);

            return;
        }

        return $this->$m;
    }
}
