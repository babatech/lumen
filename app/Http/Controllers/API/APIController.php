<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Matrix;

class APIController extends BaseController
{
    /**
     * Perform Matrix Multiplcation
     *
     * Calculate the result martirix with given two Matrix's
     * @param Request $request API Payload
     * @return JSON API response
     */
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

    /**
     * Download CSV file
     *
     * Download the Given Matrix as CSV file
     * @param Request $request API Payload
     * @return JSON API response
     */
    public function downloadCSVFile(Request $request)
    {
        $validator = Matrix::validateMatrix($request->all());
    
        if ($validator) {
            return response()->json([
                "status" => 400,
                "error" => $validator
            ], 400);
        }
        
        Matrix::prepareCSV($request->all());
        return Storage::download('app/result.csv');
    }
}
