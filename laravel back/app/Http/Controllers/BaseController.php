<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendConfirmation($result, $message){
        $response = [
            'success'=> true,
            'message'=> $message,
            'data'=> $result
        ];
        return response()->json($response, 200, ['Content-Type'=>'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function sendError($error, $code = 404){
        $response = [
            'success'=>false,
            'message'=> $error
        ];
      
        return response()->json($response, $code, ['Content-Type'=>'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
