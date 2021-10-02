<?php

declare(strict_types=1);

namespace Darekx4\Fee\Calculator\Controller;

use Darekx4\Fee\Calculator\Model\LoanApplication;
use Darekx4\Fee\Calculator\Service\FeeCalculatorInterface;

class FeeCalculator
{
    private FeeCalculatorInterface $feeCalculator;
    private LoanApplication $loanApplication;

    public function __construct(
        LoanApplication        $loanApplication,
        FeeCalculatorInterface $feeCalculator
    )
    {
        $this->feeCalculator = $feeCalculator;
        $this->loanApplication = $loanApplication;
    }

    public function calculate(): float
    {
        return $this->feeCalculator->calculate($this->loanApplication);
    }
}
