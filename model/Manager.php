<?php

namespace OpenClassrooms\BrickBreaker\Model;

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=projet5;charset=utf8', 'root', '');
        return $db;
    }
}
