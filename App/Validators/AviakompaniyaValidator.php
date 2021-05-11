<?php


namespace App\Validators;


use App\ValidatorF;

class AviakompaniyaValidator extends ValidatorF
{
    public function inputRules()
    {
        $this->validate($_POST, [
            'nazvanie' => 'required|min:1|max:255',
            'naselennyj_punkt' => 'required|min:1|max:255',
            'ulica' => 'required|min:1|max:255',
            'nomer_doma' => 'required|min:1|max:255',
            'ofis' => 'required|min:1|max:255',
        ]);
    }
}