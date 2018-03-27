<?php

namespace Blast\Redmine\SDK\Model;

class User extends RedmineModel
{
    protected $id;
    protected $login;
    protected $name;
    protected $firstname;
    protected $lastname;
    protected $mail;
    protected $apiKey;
    protected $status;
    protected $createdOn;
    protected $lastLoginOn;
    
    public function __toString(): string
    {
        return $this->firstname.' '.$this->lastname;
    }
}
