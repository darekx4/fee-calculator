<?php

namespace Darekx4\Fee\Calculator\Tests\Service;

use Darekx4\Fee\Calculator\Model\Fees;
use Darekx4\Fee\Calculator\Model\LoanApplication;
use Darekx4\Fee\Calculator\Service\FeeCalculatorService;
use PHPUnit\Framework\TestCase;

class FeesCalculatorServiceTest extends TestCase
{
    private FeeCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FeeCalculatorService(new Fees());
    }

    // After QA  Adding absolute calculations
    public function testAbsoluteFees(): void
    {
        $fee = $this->service->calculate(new LoanApplication(12, Fees::MIN_AMOUNT_TO_LOAN));
        $this->assertEquals(50.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(12, 17000));
        $this->assertEquals(340.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(12, 18000));
        $this->assertEquals(360.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(12, 19000));
        $this->assertEquals(380.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(12, Fees::MAX_AMOUNT_TO_LOAN));
        $this->assertEquals(400.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(24, Fees::MIN_AMOUNT_TO_LOAN));
        $this->assertEquals(70.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(24, 1000));
        $this->assertEquals(70.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(24, 3000));
        $this->assertEquals(120.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(24, 4000));
        $this->assertEquals(160.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(24, Fees::MAX_AMOUNT_TO_LOAN));
        $this->assertEquals(800.00, $fee);
    }

    public function testFeesFromReadMe(): void
    {
        $fee = $this->service->calculate(new LoanApplication(12, 19250));
        $this->assertEquals(385.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(24, 11500));
        $this->assertEquals(460.00, $fee);

        $fee = $this->service->calculate(new LoanApplication(24, 2750));
        $this->assertEquals(115.00, $fee);
    }

    public function testFeeWhenFeeAmountDecreases(): void
    {
        $fee = $this->service->calculate(new LoanApplication(12, 4500));
        $this->assertEquals(110.00, $fee);
    }

    public function testRoundingToFive(): void
    {
        $fee = $this->service->calculate(new LoanApplication(24, 12345));
        $this->assertEquals(495.00, $fee);
    }

    public function testFeeWhenFeeAmountStaysInTheSameThreshold(): void
    {
        $fee = $this->service->calculate(new LoanApplication(12, 2500));
        $this->assertEquals(90.00, $fee, 'It should be still 90 as next fee amount has not changed');
    }

    public function testNotSupportedTerm(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->calculate(new LoanApplication(11, 2500));
    }

    public function testNotSupportedMaxAmountValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->calculate(new LoanApplication(12, Fees::MAX_AMOUNT_TO_LOAN +1));
    }

    public function testNotSupportedMinAmountValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->calculate(new LoanApplication(12, Fees::MIN_AMOUNT_TO_LOAN -1));
    }
}
