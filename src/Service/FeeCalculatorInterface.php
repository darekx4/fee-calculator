<?php

declare(strict_types=1);

namespace Darekx4\Fee\Calculator\Service;

use Darekx4\Fee\Calculator\Model\LoanApplication;

interface FeeCalculatorInterface
{
    public function calculate(LoanApplication $application): float;
}
