<?php


namespace App\Validators;


use App\ValidatorF;

class BiletValidator extends ValidatorF
{
    public function inputRules()
    {
        $this->validate($_POST, [
            'shifr_aviakompanii' => 'required|numeric',
            'nomer_kassy' => 'required|numeric',
            'tabelnyj_nomer_kassira' => 'required|numeric',
            'tip' => 'required|min:1|max:255',
            'data_prodazhi' => 'required|date',
        ]);
    }
}