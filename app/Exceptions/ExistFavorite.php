<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExistFavorite extends Exception
{
    public function render(Request $request): Response
    {
        return new Response([
            'message' => $this->message
        ],$this->code,['content-type' => 'application/json; charset=utf-8']);
    }
}
