<?php

use PHPUnit\Framework\TestCase;
use App\Libraries\Calculator;

final class CalculatorTest extends TestCase{

    public function testAddNumbers(){

        $calc = new Calculator;
        $values = [
            [2,2,4],
            [-1,-5,-6],
            [9.8, 7.9, 17.7]
        ];
        
        foreach($values as $numbers){

            $this->assertEquals($numbers[2], $calc->add($numbers[0], $numbers[1]));

        }

    }

    public function testThrowsExceptionIfNonNumericIsPassed(){

        $this->expectException(InvalidArgumentException::class);
        $calc = new Calculator;
        $calc->add("a", []);

    }


}

?>