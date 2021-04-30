<?php


namespace App\Models;


use App\Model;

class Bilet extends Model
{
    protected static $table = 'bilet';
    public $shifr_aviakompanii;
    public $nomer_kassy;
    public $tabelnyj_nomer_kassira;
    public $tip;
    public $data_prodazhi;
}