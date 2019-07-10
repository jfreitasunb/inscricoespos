<?php

namespace InscricoesPos\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayUnico implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    
    public function array_has_duplicates($array)
    {
        return count($array) !== count(array_unique($array));
    }
    
    public function passes($attribute, $value)
    {
        return $this->array_has_duplicates($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Você anexou documentos duplicados. Verifique e envie os documentos corretos.';
    }
}
