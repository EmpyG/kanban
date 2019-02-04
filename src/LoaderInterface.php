<?php declare (strict_types=1);

namespace App;

interface LoaderInterface
{
    public function getType();

    public function getName();

    public function getServer();

    public function getUsername();

    public function getPassword();

    public function getCharset();
}