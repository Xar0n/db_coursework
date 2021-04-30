<?php


namespace App\Models;


use App\Model;

class Aviakompaniya extends Model
{
    protected static $table = 'aviakompaniya';
    public $nazvanie;
    public $naselennyj_punkt;
    public $ulica;
    public $nomer_doma;
    public $ofis;
}