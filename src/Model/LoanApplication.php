<?php

declare(strict_types=1);

namespace Darekx4\Fee\Calculator\Model;

/**
 * A cut down version of a loan application containing
 * only the required properties for this test.
 */
class LoanApplication
{
    private int $term;
    private float $amount;

    public function __construct(int $term, float $amount)
    {
        $this->term = $term;
        $this->amount = $amount;
    }

    /**
     * Term (loan duration) for this loan application
     * in number of months.
     */
    public function term(): int
    {
        return $this->term;
    }

    /**
     * Amount requested for this loan application.
     */
    public function amount(): float
    {
        return $this->amount;
    }
}
