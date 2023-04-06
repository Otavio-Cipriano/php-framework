<?php

namespace app\core;

use Exception;

class Validate {

    private array $inputs;

    private array $fields;

    public array $invalidFields;

    private array $restrains;

    private array $options = ['regex', 'min', 'max', 'is_required', 'is_email', 'same'];

    function __construct(array $inputs, array $restrains)
    {
        $this->inputs = $inputs;
        $this->restrains = $restrains;
        $this->invalidFields = [];
        $this->fields = $this->extract_fields();
    }

    public function validate(){
        foreach($this->fields as $input => $fields){
            foreach($fields as $prop => $value){
                if(!in_array($prop, $this->options) && $prop !== 'value') return throw new Exception("This option $prop doesn't exist");
                
                if(isset($value) && isset($fields['value'])){
                    switch ($prop) {
                        case 'regex':
                            $this->validate_regex($fields['value'], $value, $input);
                            break;
                        case 'is_email':
                            $this->validate_email($fields['value'], $input, $value);
                            break;
                        case 'same':
                            $this->is_same($fields['value'], $value, $input);
                            break;
                        case 'min':
                            $this->validate_min($fields['value'], $value, $input);
                            break;
                        case 'max':
                            $this->validate_max($fields['value'], $value, $input);
                            break;
                        case 'is_required':
                            $this->is_required($fields['value'], $input, $value);
                            break;
                    }
                }
            }
        }
    }

    public function validate_regex(mixed $value, string $regex, string $field){
        if(!empty($regex)){
            if(!preg_match($regex, $value)){
                $this->insert_error($field, 'regex', 'Caractere Invalido');
            }
        }
    }

    public function validate_min(mixed $value, int $min, string $field){
        if(isset($min) && !empty($value)){
            if(strlen($value) < $min){
                $this->insert_error($field, 'min', "É necessário no minimo $min caracteres");
            }
        }
    }

    public function validate_email(mixed $value, string $field, bool $is_email = false){
        if($is_email && !empty($value)){
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                $this->insert_error($field, 'email', "Este email não é valido");
            }
        }
    }

    public function validate_max(mixed $value, int $max, string $field){
        if(isset($max) && !empty($value)){
            if(strlen($value) > $max){
                $this->insert_error($field, 'max', "É necessário no máximo $max caracteres");
            }
        }
    }
    
    public function is_required(mixed $value, string $field, $required = false){
    if($required){
            if(empty($value)){
                $this->insert_error($field, 'required', "Este Campo é requirido");
            }
    }
    }

    public function is_same(mixed $value, string $field_to_check, string $field){
        if(!empty($field_to_check)){
            if($value !== $this->inputs[$field_to_check]){
                $this->insert_error($field, 'same', "Campo diferente de $field_to_check");
            }
        }
    }

    public function extract_fields(){
        $fields = [];

        foreach($this->restrains as $key => $value){
            if(!array_key_exists($key, $this->inputs)) return throw new Exception("the Key $key doesn't exist");
            
            $newField = ['value' => $this->inputs[$key], ...$value];
            $fields = [...$fields, $key => $newField];
        }

        return $fields;
    }

    public function all_valid(){
        if(count($this->invalidFields) > 0){
            return false;
        }

        return true;
    }

    public function insert_error(string $field, string $error_type, string $msg){
        if(isset($this->invalidFields[$field])){
            return $this->invalidFields = [...$this->invalidFields, $field => [...$this->invalidFields[$field], $msg]];
        }

        return $this->invalidFields = [...$this->invalidFields, $field => [$msg]];
    }
}
?>