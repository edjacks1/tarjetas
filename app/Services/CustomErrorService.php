<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;

class CustomErrorService {

    private $error;

    public function __construct(ValidationException $error){
       $this->error = $error;
    }  

    public function getCustomErrors(){
        $errors       = $this->error->validator->failed();
        $customErrors = array();

        foreach($errors as $key => $value){
            $rule = array_keys($value)[0];
            //get customized errors
            switch($rule){
                case "Required": $customErrors["$key"] = ["required"     => TRUE]; break;
                case "Max"     : $customErrors["$key"] = ["maxlength"    => TRUE]; break;
                case "Min"     : $customErrors["$key"] = ["minlength"    => TRUE]; break;
                case "Email"   : $customErrors["$key"] = ["email"        => TRUE]; break;
                case "Unique"  : $customErrors["$key"] = ["unique"       => TRUE]; break;
                case "Image"   : $customErrors["$key"] = ["imagen"       => TRUE]; break;
                case "Exists"  : $customErrors["$key"] = ["verificacion" => TRUE]; break;
            }
        }
        return $customErrors;
    }

}