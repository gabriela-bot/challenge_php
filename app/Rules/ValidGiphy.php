<?php

namespace App\Rules;

use App\Service\GiphyService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidGiphy implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $giphyService = new GiphyService();

        $giphy = $giphyService->getById($value,true);

        $exist = rescue(fn() => $giphy['id'], false, false);

        if(!$exist){
            $fail('Giphy not found.');
        }

    }
}
