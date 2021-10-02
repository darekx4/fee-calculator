<?php

declare(strict_types=1);

namespace Darekx4\Fee\Calculator\Service;

use Exception;
use InvalidArgumentException;
use Darekx4\Fee\Calculator\Model\Fees;
use Darekx4\Fee\Calculator\Model\FeesInterface;
use Darekx4\Fee\Calculator\Model\LoanApplication;

class FeeCalculatorService implements FeeCalculatorInterface
{
    public FeesInterface $fees;

    public function __construct(FeesInterface $fees)
    {
        $this->fees = $fees;
    }

    /**
     * @throws Exception
     */
    public function calculate(LoanApplication $application): float
    {
        $amountToLoan = $application->amount();
        $term = $application->term();

        if ($amountToLoan < Fees::MIN_AMOUNT_TO_LOAN) {
            throw new InvalidArgumentException(
                'Provided amount is smaller than required minimum ' . Fees::MIN_AMOUNT_TO_LOAN
            );
        }

        if ($amountToLoan > Fees::MAX_AMOUNT_TO_LOAN) {
            throw new InvalidArgumentException(
                'Provided amount is bigger than required maximum ' . Fees::MAX_AMOUNT_TO_LOAN
            );
        }

        if (!in_array($term, Fees::$allowedTerms, true)) {
            throw new InvalidArgumentException(
                'Provided term is not currently supported'
            );
        }

        $feesForTheTerm = $this->fees->getFeesForTerm($term);

        foreach ($feesForTheTerm as $key => $fee) {
            $currentAmount = $fee['amount'];
            $currentFee = $fee['fee'];

            //After QA Fix sorting MAX absolute values - if this is higher possible value
            $nextAmount = $amountToLoan == Fees::MAX_AMOUNT_TO_LOAN ? $currentAmount : $feesForTheTerm[$key + 1]['amount'];
            $nextFee = $amountToLoan == Fees::MAX_AMOUNT_TO_LOAN ? $currentFee : $feesForTheTerm[$key + 1]['fee'];

            //After QA Fix sorting other absolute values - if this is lower possible value
            $nextAmount = $currentAmount == $amountToLoan ? $currentAmount : $nextAmount;
            $nextFee = $currentAmount == $amountToLoan ? $currentFee : $nextFee;

            if (($amountToLoan > $currentAmount) && ($amountToLoan < $nextAmount)) {
                break;
            }

            // After QA  Fix for absolute values
            if ($currentAmount == $amountToLoan) {
                break;
            }
        }

        // That should never happen - just to make code more defensive
        if (!isset($currentAmount, $currentFee, $nextAmount, $nextFee)) {
            throw new Exception(
                'Unexpected Error - FeeCalculatorService could not find amounts for calculation'
            );
        }

        // When we do not have difference between fees for next level
        if ($currentFee === $nextFee) {
            return $currentFee;
        }

        // Calculate ratio of the reminder within the slot
        $reminder = $amountToLoan - $currentAmount;
        $ratio = ($nextAmount - $currentAmount) / $reminder;

        // Calculate fee
        $calculateFee = (($nextFee - $currentFee) / $ratio) + $currentFee;

        // Round to 5
        return ceil($calculateFee / 5) * 5;
    }
}
