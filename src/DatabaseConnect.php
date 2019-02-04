<?php declare (strict_types=1);

namespace App;

use Medoo\Medoo;

class DatabaseConnect
{
    /**
     * Sets database handler
     *
     * @param LoaderInterface $config
     * @return Medoo
     */
    public static function getDatabase(LoaderInterface $config)
    {
        return new Medoo([
            'database_type' => $config->getType(),
            'database_name' => $config->getName(),
            'server'        => $config->getServer(),
            'username'      => $config->getUsername(),
            'password'      => $config->getPassword(),
            'charset'       => $config->getCharset(),
        ]);
    }
}