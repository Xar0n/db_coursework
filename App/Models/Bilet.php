<?php


namespace App\Models;


use App\DB;
use App\Model;

class Bilet extends Model
{
    protected static $table = 'bilet';
    public $shifr_aviakompanii;
    public $nomer_kassy;
    public $tabelnyj_nomer_kassira;
    public $tip;
    public $data_prodazhi;

    public static function findAllRelated()
    {
        $db = new DB();
        $sql = 'SELECT bilet.*, aviakompaniya.nazvanie AS nazvanie_a, aviakompaniya.naselennyj_punkt AS naselennyj_punkt_a, 
       aviakompaniya.ulica AS ulica_a, aviakompaniya.nomer_doma AS nomer_doma_a, aviakompaniya.ofis AS ofis_a, 
       kassa.naselennyj_punkt, kassa.ulica, kassa.nomer_doma, kassir.familiya, kassir.imya, kassir.otchestvo FROM `bilet`, 
       `aviakompaniya`, `kassa`, `kassir` WHERE bilet.shifr_aviakompanii = aviakompaniya.id AND bilet.nomer_kassy = kassa.id 
                                            AND bilet.tabelnyj_nomer_kassira = kassir.id';
        return $db->query($sql, [], static::class);
    }
}