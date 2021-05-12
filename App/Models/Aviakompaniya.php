<?php


namespace App\Models;


use App\DB;
use App\Model;

class Aviakompaniya extends Model
{
    protected static $table = 'aviakompaniya';
    public $nazvanie;
    public $naselennyj_punkt;
    public $ulica;
    public $nomer_doma;
    public $ofis;

    public static function uniqueNazvanie($nazvanie)
    {
        $db = new DB();
        $sql = 'SELECT * FROM `aviakompaniya` WHERE nazvanie = \''.$nazvanie.'\'';
        return empty($db->query($sql, [], static::class));
    }
}