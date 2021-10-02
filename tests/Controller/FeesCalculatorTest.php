<?php

namespace Darekx4\Fee\Calculator\Tests\Controller;

use Darekx4\Fee\Calculator\Controller\FeeCalculator;
use Darekx4\Fee\Calculator\Model\Fees;
use Darekx4\Fee\Calculator\Model\LoanApplication;
use Darekx4\Fee\Calculator\Service\FeeCalculatorService;
use PHPUnit\Framework\TestCase;

class FeesCalculatorTest extends TestCase
{

    public function testFeesFromReadMe(): void
    {
        $fee = new FeeCalculator(
            new LoanApplication(12, 19250),
            new FeeCalculatorService(new Fees())
        );

        $this->assertEquals(385.00, $fee->calculate());

        $fee = new FeeCalculator(
            new LoanApplication(24, 11500),
            new FeeCalculatorService(new Fees())
        );

        $this->assertEquals(460.00, $fee->calculate());

        $fee = new FeeCalculator(
            new LoanApplication(24, 2750),
            new FeeCalculatorService(new Fees())
        );

        $this->assertEquals(115.00, $fee->calculate());
    }

    public function testFeeWhenFeeAmountDecreases(): void
    {
        $fee = new FeeCalculator(
            new LoanApplication(12, 4500),
            new FeeCalculatorService(new Fees())
        );

        $this->assertEquals(110.00, $fee->calculate());
    }

    public function testRoundingToFive(): void
    {
        $fee = new FeeCalculator(
            new LoanApplication(24, 12345),
            new FeeCalculatorService(new Fees())
        );

        $this->assertEquals(495.00, $fee->calculate());
    }

    public function testFeeWhenFeeAmountStaysInTheSameThreshold(): void
    {
        $fee = new FeeCalculator(
            new LoanApplication(12, 2500),
            new FeeCalculatorService(new Fees())
        );

        $this->assertEquals(90.00, $fee->calculate(), 'It should be still 90 as next fee amount has not changed');
    }

    public function testNotSupportedTerm(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $notSupportedTerm = 11;
        $fee = new FeeCalculator(
            new LoanApplication($notSupportedTerm, 2500),
            new FeeCalculatorService(new Fees())
        );

        $fee->calculate();
    }

    public function testNotSupportedMaxAmountValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $fee = new FeeCalculator(
            new LoanApplication(12, Fees::MAX_AMOUNT_TO_LOAN +1),
            new FeeCalculatorService(new Fees())
        );

        $fee->calculate();
    }

    public function testNotSupportedMinAmountValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $fee = new FeeCalculator(
            new LoanApplication(12, Fees::MIN_AMOUNT_TO_LOAN - 1),
            new FeeCalculatorService(new Fees())
        );

        $fee->calculate();
    }
}
