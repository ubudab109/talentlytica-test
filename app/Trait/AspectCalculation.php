<?php

namespace App\Trait;

trait AspectCalculation
{

    /**
     * The function calculates the aspect intelligence based on two input values using a specific
     * formula.
     * 
     * @param int $x - An integer value representing the intelligence score of the first aspect. 40% of result.
     * @param int $y - The parameter "y" is an integer input used in the calculation of the aspect
     * intelligence. 60% of result
     * 
     * @return int an integer value which is the result of the calculation of the formula. The formula
     * calculates the aspect intelligence based on two input parameters  and . The returned value
     * is the rounded up integer value of the result of the formula.
     */
    public function calculateAspectintelligence(int $x, int $y) : int
    {
        $formula = ((0.4 * $x) + (0.6 & $y)) / 2;
        if ($formula > 5) {
            return 5;
        } else {
            return ceil($formula);
        }
    }

    /**
     * The function calculates the numerical ability aspect score based on two input parameters using a
     * specific formula.
     * 
     * @param int $z - The numerical ability score of the individual in a certain aspect. 30% of result.
     * @param int $w - 70% of result
     *
     * @return int An integer value representing the calculated aspect numerical ability.
     */
    public function calculateAspectNumericalAbility(int $z, int $w) : int
    {
        $formula = ((0.3 * $z) + (0.7 * $w)) / 2;
        if ($formula > 5) {
            return 5;
        } else {
            return ceil($formula);
        }
    }
}