<?php

namespace App\Traits;

trait HTTPResponses
{
    protected function sucess($data, $message = null, $code = 200)
    {

        return response()->json([
            'status' => 'Request was succesful ',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($data, $message = null, $code)
    {

        return response()->json([
            'status' => 'Errot has occured...',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
