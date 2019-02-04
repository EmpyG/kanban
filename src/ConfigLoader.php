<?php declare (strict_types=1);

namespace App;

class ConfigLoader implements LoaderInterface
{
    public $err;
    private $type;
    private $name;
    private $server;
    private $username;
    private $password;
    private $charset;

    public function __construct(array $cfg)
    {
        $this->err = false;
        if (!isset($cfg['type'],
            $cfg['name'],
            $cfg['server'],
            $cfg['username'],
            $cfg['password'],
            $cfg['charset'])) {
            $this->err = true;
            return;
        }

        $this->type = $cfg['type'];
        $this->name = $cfg['name'];
        $this->server = $cfg['server'];
        $this->username = $cfg['username'];
        $this->password = $cfg['password'];
        $this->charset = $cfg['charset'];
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getCharset()
    {
        return $this->charset;
    }
}