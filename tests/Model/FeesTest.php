<?php

namespace Darekx4\Fee\Calculator\Tests\Model;

use Darekx4\Fee\Calculator\Model\Fees;
use PHPUnit\Framework\TestCase;

class FeesTest extends TestCase
{
    public function testGetFeedsForSupportedTerms(): void
    {
        $supportedTerms = Fees::$allowedTerms;

        foreach($supportedTerms as $term){
            $fees = (new Fees())->getFeesForTerm($term);
            foreach ($fees as $fee){
                $this->assertNotEmpty($fee['amount']);
                $this->assertNotEmpty($fee['fee']);
            }
        }
    }

    public function testGetFeedsForNotSupportedTerms(): void
    {
        $notSupportedTerms = [1,3,5,90];

        foreach($notSupportedTerms as $term){
            $fees = (new Fees())->getFeesForTerm($term);
            $this->assertEmpty($fees);
        }

    }
}
