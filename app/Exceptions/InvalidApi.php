<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvalidApi extends Exception
{

    public $content;

    public function __construct($content,$code = 0, Exception $previous = null)
    {
        $msg = $content['meta']['msg'];
        $code = $content['meta']['status'];
        parent::__construct($msg, $code);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response
    {
        return new Response([
            'message' => $this->message
        ],$this->code,['content-type' => 'application/json; charset=utf-8']);
    }
}
