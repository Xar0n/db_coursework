<?php


namespace App\Models;


use App\DB;
use App\Model;

class Kassir extends Model
{
    protected static $table = 'kassir';
    public $nomer_kassy;
    public $familiya;
    public $imya;
    public $otchestvo;

    public static function findAllRelated()
    {
        $db = new DB();
        $sql = 'SELECT kassir.*, kassa.naselennyj_punkt, kassa.ulica, kassa.nomer_doma FROM `kassir`, `kassa` WHERE kassir.nomer_kassy = kassa.id ';
        return $db->query($sql, [], static::class);
    }

    public static function kassirsToKassa($idKassa)
    {
        $db = new DB();
        $sql = 'SELECT * FROM `kassir` WHERE nomer_kassy = '.$idKassa;
        return $db->query($sql, [], static::class);
    }
}