<?php


namespace App\Validators;


use App\ValidatorF;

class KassirValidator extends ValidatorF
{
    public function inputRules()
    {
        $this->validate($_POST, [
            'nomer_kassy' => 'required|numeric',
            'familiya' => 'required|min:1|max:255',
            'imya' => 'required|min:1|max:255',
            'otchestvo' => 'required|min:1|max:255',
        ]);
    }
}