<?php


namespace App\Models;


use App\Model;

class Kassa extends Model
{
    protected static $table = 'kassa';
    public $naselennyj_punkt;
    public  $ulica;
    public  $nomer_doma;
}