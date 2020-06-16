<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class APITest extends TestCase
{
    /**
     * A basic validation test with missing data.
     *
     * @return void
     */
    public function testValidateMatrixWithMissingData()
    {
        $this->post('api/calculate', ["matrixB" => [[]]])
        ->seeJson([
            "error" => [
                "Matrix A is required",
                "Matrix B should have a nested element"
            ],
            "status" => 400
         ]);
    }

    /**
     * A basic validation test with invalid data.
     *
     * @return void
     */
    public function testValidateMatrixWithInvalidData()
    {
        $this->post('api/calculate', ["matrixA" => [], "matrixB" => [[]]])
        ->seeJson([
            "error" => [
                "Matrix A is required",
                "Matrix B should have a nested element"
            ],
            "status" => 400
         ]);
    }


    /**
     * A basic validation test with empty data.
     *
     * @return void
     */
    public function testValidateMatrixWithValidEmptyData()
    {
        $this->post('api/calculate', ["matrixA" => [[]], "matrixB" => [[]]])
        ->seeJson([
            "error" => [
                "Matrix A should have a nested element",
                "Matrix B should have a nested element"
            ],
            "status" => 400
         ]);
    }




    /**
     * A basic validation test with non numeric data.
     *
     * @return void
     */
    public function testValidateMatrixWithNonNumericData()
    {
        $this->post('api/calculate', ["matrixA" => [[["value" => "2"]]], "matrixB" => [[["value" => 8]]]])
        ->seeJson([
            "error" => [
                "Matrix A nested array should be an numeric"
            ],
            "status" => 400
         ]);
    }

    /**
     * A basic validation test with valid numeric data.
     *
     * @return void
     */
    public function testValidateMatrixWithValidNumericData()
    {
        $this->post('api/calculate', ["matrixA" => [[["value" => 2]]], "matrixB" => [[["value" => 8]]]])
        ->seeJson([
            "result" => [
                [["value" => 16,"x" => "A","y" => 0]]
            ],
            "status" => 200
         ]);
    }
}
