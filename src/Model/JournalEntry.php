<?php

namespace Blast\RedmineSDK\Model;

class JournalEntry extends RedmineModel
{
    protected $id;
    protected $user;
    protected $notes;
    protected $createsOn;
    protected $details = [];


    protected function hydrateValue($value, ?string $name = null)
    {
        switch ($name) {
            case 'user':
                return User::create($value);
            default:
                return parent::hydrateValue($value, $name);
        }
    }
}
