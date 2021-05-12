<?php


namespace App\Validators;


use App\ValidatorF;

class KuponValidator extends ValidatorF
{
    public function inputRules()
    {
        $this->validate($_POST, [
            'nomer_bileta' => 'required|numeric',
            'nomer_i_seriya_pasporta_klienta' => 'required|min:10|max:10',
            'nunkt_posadki' => 'required|min:1|max:255',
            'nunkt_vysadki' => 'required|min:1|max:255',
            'tarif' => 'required|integer',
        ]);
    }
}