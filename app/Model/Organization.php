<?php

namespace ZTT\app\Model;

class Organization
{
    public $id;
    public $avatarUrl;
    public $login;
    public $description;

    /**
     * Organization constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->avatarUrl = !empty($data['avatar_url']) ? $data['avatar_url'] : null;
        $this->login = !empty($data['login']) ? $data['login'] : null;
        $this->description = !empty($data['description']) ? $data['description'] : null;
    }
}
