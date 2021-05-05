<?php


namespace App\Models;


use App\DB;
use App\Model;

class Kupon extends Model
{
    protected static $table = 'kupon';
    public $nomer_bileta;
    public $nomer_i_seriya_pasporta_klienta;
    public $nunkt_posadki;
    public $nunkt_vysadki;
    public $tarif;

    public static function countKupon($nomerBileta)
    {
        $db = new DB();
        $sql = 'SELECT * FROM '. self::$table .' WHERE nomer_bileta = '.$nomerBileta;
        return count($db->query($sql, [], static::class));
    }
}