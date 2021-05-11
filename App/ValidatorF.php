<?php

namespace App;

use Rakit\Validation\Validator;

abstract class ValidatorF
{
    protected $validator;
    protected $validation;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    /**
     * @param $global_arr
     * @param $rules
     */
    public function validate($global_arr, $rules)
    {
        $this->validation = $this->validator->make($global_arr, $rules);
        $this->validation->validate();
    }

    /**
     *
     */
    public function inputRules() {

    }

    /**
     * @return mixed
     */
    public function getResultObject(){
        return $this->validation;
    }

    /**
     * @return mixed
     */
    public function getResultBool(){
        return $this->validation->fails();
    }

    /**
     * @return mixed
     */
    public function getResultErrors(){
        return $this->validation->errors();
    }
}