<?php


namespace App\Models;


use App\Model;

class Klient extends Model
{
    protected static $table = 'klient';
    public $familiya;
    public $imya;
    public $otchestvo;
}