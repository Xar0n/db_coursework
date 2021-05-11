<?php
namespace App\Validators;

use App\ValidatorF;

class ValidatorKlient extends ValidatorF
{
    public function inputRules()
    {
        $this->validate($_POST, [
            'nomer_i_seriya_pasporta' => 'required|min:10|max:10',
            'familiya' => 'required|min:1|max:255',
            'imya' => 'required|min:1|max:255',
            'otchestvo' => 'required|min:1|max:255',
        ]);
    }
}