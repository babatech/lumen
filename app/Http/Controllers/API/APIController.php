<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Matrix;

class APIController extends BaseController
{
    public function calculate(Request $request)
    {
        
        $validator = Matrix::validate($request->all());
    
        if ($validator) {
            return response()->json([
                "status" => 400,
                "error" => $validator
            ], 400);
        }
        
        return response()->json([
            "status" => 200,
            "result" => Matrix::multiplication($request->all())
        ], 200);
    }
}
