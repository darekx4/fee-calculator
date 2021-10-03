Coding Challenge - Fee Calculation
=====
[![License: MIT](https://img.shields.io/badge/License-MIT-limegreen.svg)](https://opensource.org/licenses/MIT)
[![Fee Calculation](https://github.com/darekx4/fee-calculator/actions/workflows/php.yml/badge.svg)](https://github.com/darekx4/fee-calculator/actions/workflows/php.yml)

## Background

Design your solution in a way that shows your knowledge of OOP concepts, SOLID principles, design patterns, clean and extensible architecture.

Used PHP PHP 7.4 and phpunit tests

## The test

The requirement is to build a fee calculator that - given a monetary **amount** and a **term** (the contractual duration of the loan, expressed as a number of months) - will produce an appropriate fee for a loan, based on a fee structure and a set of rules described below. A general contract for this functionality is defined in the interface `FeeCalculator`.

Implement your solution such that it fulfils the requirements.

- The fee structure does not follow a formula.
- Values in between the breakpoints should be interpolated linearly between the lower bound and upper bound that they fall between.
- The number of breakpoints, their values, or storage might change.
- The term can be either 12 or 24 (number of months), you can also assume values will always be within this set.
- The fee should be rounded up such that fee + loan amount is an exact multiple of 5.
- The minimum amount for a loan is £1,000, and the maximum is £20,000.
- You can assume values will always be within this range but they may be any value up to 2 decimal places.

Example inputs/outputs:
|Loan amount  |Term       |Fee     |
|-------------|-----------|--------|
|£11,500      |24 months  |£460    |
|£19,250      |12 months  |£385    |

# Installation
A database or any other external dependency is not required for this test.

```bash
composer install
```

# Example
```php
<?php

use Darekx4\Fee\Calculator\Model\LoanApplication;

$calculator = new FeeCalculator();

$application = new LoanApplication(24, 2750);
$fee = $calculator->calculate($application);
// $fee = (float) 115.0
```

# Fee Structure
The fee structure doesn't follow particular algorithm and it is possible that same fee will be applicable for different amounts.

### Term 12
```
£1000: £50
£2000: £90
£3000: £90
£4000: £115
£5000: £100
£6000: £120
£7000: £140
£8000: £160
£9000: £180
£10000: £200
£11000: £220
£12000: £240
£13000: £260
£14000: £280
£15000: £300
£16000: £320
£17000: £340
£18000: £360
£19000: £380
£20000: £400
```

### Term 24

```
£1000: £70
£2000: £100
£3000: £120
£4000: £160
£5000: £200
£6000: £240
£7000: £280
£8000: £320
£9000: £360
£10000: £400
£11000: £440
£12000: £480
£13000: £520
£14000: £560
£15000: £600
£16000: £640
£17000: £680
£18000: £720
£19000: £760
£20000: £800
```
