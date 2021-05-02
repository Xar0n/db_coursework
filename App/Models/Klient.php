<?php


namespace App\Models;


use App\Model;

class Klient extends Model
{
    protected static $table = 'klient';
    public $nomer_i_seriya_pasporta;
    public $familiya;
    public $imya;
    public $otchestvo;
}