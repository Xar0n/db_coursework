<?php


namespace App;


abstract class Request
{
    protected static function request($sql)
    {
        $db = new DB();
        return $db->querySimple($sql,[]);
    }
}