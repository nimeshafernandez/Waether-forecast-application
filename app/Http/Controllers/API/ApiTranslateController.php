<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ApiTranslateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function toSinhala($keyword)
    {
        $response = Http::get('http://easysinhalaunicode.com/php/API.php?action=convert&data=' . $keyword)->body();
        return response()->json($response, 200);
    }
}
