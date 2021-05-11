<?php


namespace App\Validators;


use App\ValidatorF;

class KassaValidator extends ValidatorF
{
    public function inputRules()
    {
        $this->validate($_POST, [
            'naselennyj_punkt' => 'required|min:1|max:255',
            'ulica' => 'required|min:1|max:255',
            'nomer_doma' => 'required|min:1|max:255',
        ]);
    }
}