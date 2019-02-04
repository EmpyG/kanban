<?php declare (strict_types=1);

namespace App;

use Medoo\Medoo;

class DatabaseConnect
{
    /**
     * Sets database handler
     *
     * @param LoaderInterface $config
     */
    public static function getDatabase(LoaderInterface $config)
    {
        if ($config->err) throw new Exception('No keys in array.');

        return new Medoo([
            'database_type' => $config->getType(),
            'database_name' => $config->getName(),
            'server' => $config->getServer(),
            'username' => $config->getUsername(),
            'password' => $config->getPassword(),
            'charset' => $config->getCharset(),
        ]);
    }
}