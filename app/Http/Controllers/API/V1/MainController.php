<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            "status" => true,
            "body" => [],
            "message" => "Успешно!"
        ], 200);
    }
}
