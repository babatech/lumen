<?php

declare(strict_types=1);

namespace App;

use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Array_;

class Matrix
{
    /**
     * Perform Matrix multiplication
     *
     * The resulting matrix should contain characters rather than numbers - similar to excel columns.
     * @param Array $param Call parameters
     * @return Array
     */
    public static function multiplication($param)
    {
        $result = array();
        for ($i = 0; $i < count($param["matrixA"]); $i++) {
            for ($j = 0; $j < count($param["matrixB"][0]); $j++) {
                $result[$i][$j] = 0;
                for ($k = 0; $k < count($param["matrixB"]); $k++) {
                    $result[$i][$j] += $param["matrixA"][$i][$k]["value"] * $param["matrixB"][$k][$j]["value"];
                }
                $result[$i][$j] = ["x" => Matrix::getColumnName($j), "y" => $i, "value" => $result[$i][$j]];
            }
        }
        return (array) $result;
    }

    /**
     * Matrix validation for matrix multiplication
     *
     * For Matrix multiplication, the column count in the first matrix should be equal to the row count of the
     * second matrix. If this condition is not met, the app should throw a validation error.
     * @param Array $matrix1  Matrix 1
     * @param Array $matrix2  Matrix 2
     * @return Boolean
     */
    public static function isInvalidMatrixs($matrix1, $matrix2)
    {
        if (count($matrix1[0]) !== count($matrix2)) {
            return true;
        }
        return false;
    }

    /**
     * Validation error messages
     * @return Array List of validation error message
     */
    public static function messages()
    {
        return [
            'matrixA.required' => 'Matrix A is required',
            'matrixA.array' => 'Matrix A should be an array',
            'matrixA.min' => 'Matrix A is invalid',
            'matrixA.*.required' => 'Matrix A should have a nested element',
            'matrixA.*.array' => 'Matrix A nested element should be an array',
            'matrixA.*.min' => 'Matrix A is empty',
            'matrixA.*.numericarray' => 'Matrix A nested array should be an numeric',
            'matrixB.required' => 'Matrix B is required',
            'matrixB.array' => 'Matrix B should be an array',
            'matrixB.min' => 'Matrix B is invalid',
            'matrixB.*.required' => 'Matrix B should have a nested element',
            'matrixB.*.array' => 'Matrix B nested element should be an array',
            'matrixB.*.min' => 'Matrix B is empty',
            'matrixB.*.numericarray' => 'Matrix B nested array should be an numeric'
        ];
    }

    /**
     * Validation rules
     * @return Array List of validation rules
     */
    public static function rules()
    {
        Validator::extend('numericarray', function ($attribute, $value, $parameters) {
            foreach ($value as $v) {
                if (!is_int($v["value"])) {
                    return false;
                }
            }
            return true;
        });
        return [
            'matrixA' => 'required|array|min:1',
            'matrixB' => 'required|array|min:1',
            'matrixA.*' => 'required|array|min:1|numericarray',
            'matrixB.*' => 'required|array|min:1|numericarray',
        ];
    }

    public static function validate($param)
    {
        $validator = Validator::make($param, Matrix::rules(), Matrix::messages());

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        if (Matrix::isInvalidMatrixs($param["matrixA"], $param["matrixB"])) {
            return ["Matrix A columns should be equal to Matrix B rows"];
        }
        return false;
    }

    public static function getColumnName($index)
    {
        $numeric = $index % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($index / 26);
        if ($num2 > 0) {
            return Matrix::getColumnName($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }
}
