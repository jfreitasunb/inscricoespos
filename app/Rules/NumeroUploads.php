<?php

namespace InscricoesPos\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumeroUploads implements Rule
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
    public function passes($attribute, $value)
    {
        foreach ($value as $key => $value) {
            $array_temp[] = $value->getClientOriginalName();
        }

        return (count($array_temp) >= 4);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('documentos_matricula.numero_minino');
    }
}
