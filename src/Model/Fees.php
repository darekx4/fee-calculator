<?php

declare(strict_types=1);

namespace Darekx4\Fee\Calculator\Model;

class Fees implements FeesInterface
{
    public const MIN_AMOUNT_TO_LOAN = 1000;
    public const MAX_AMOUNT_TO_LOAN = 20000;
    public static array $allowedTerms = [12, 24];

    private static array $valueMap = [
        ['term' => 12, 'amount' => self::MIN_AMOUNT_TO_LOAN, 'fee' => 50],
        ['term' => 12, 'amount' => 2000, 'fee' => 90],
        ['term' => 12, 'amount' => 3000, 'fee' => 90],
        ['term' => 12, 'amount' => 4000, 'fee' => 115],
        ['term' => 12, 'amount' => 5000, 'fee' => 100],
        ['term' => 12, 'amount' => 6000, 'fee' => 120],
        ['term' => 12, 'amount' => 7000, 'fee' => 140],
        ['term' => 12, 'amount' => 8000, 'fee' => 160],
        ['term' => 12, 'amount' => 9000, 'fee' => 180],
        ['term' => 12, 'amount' => 10000, 'fee' => 200],
        ['term' => 12, 'amount' => 11000, 'fee' => 220],
        ['term' => 12, 'amount' => 12000, 'fee' => 240],
        ['term' => 12, 'amount' => 13000, 'fee' => 260],
        ['term' => 12, 'amount' => 14000, 'fee' => 280],
        ['term' => 12, 'amount' => 15000, 'fee' => 300],
        ['term' => 12, 'amount' => 16000, 'fee' => 320],
        ['term' => 12, 'amount' => 17000, 'fee' => 340],
        ['term' => 12, 'amount' => 18000, 'fee' => 360],
        ['term' => 12, 'amount' => 19000, 'fee' => 380],
        ['term' => 12, 'amount' => self::MAX_AMOUNT_TO_LOAN, 'fee' => 400],
        ['term' => 24, 'amount' => self::MIN_AMOUNT_TO_LOAN, 'fee' => 70],
        ['term' => 24, 'amount' => 2000, 'fee' => 100],
        ['term' => 24, 'amount' => 3000, 'fee' => 120],
        ['term' => 24, 'amount' => 4000, 'fee' => 160],
        ['term' => 24, 'amount' => 5000, 'fee' => 200],
        ['term' => 24, 'amount' => 6000, 'fee' => 240],
        ['term' => 24, 'amount' => 7000, 'fee' => 280],
        ['term' => 24, 'amount' => 8000, 'fee' => 320],
        ['term' => 24, 'amount' => 9000, 'fee' => 360],
        ['term' => 24, 'amount' => 10000, 'fee' => 400],
        ['term' => 24, 'amount' => 11000, 'fee' => 440],
        ['term' => 24, 'amount' => 12000, 'fee' => 480],
        ['term' => 24, 'amount' => 13000, 'fee' => 520],
        ['term' => 24, 'amount' => 14000, 'fee' => 560],
        ['term' => 24, 'amount' => 15000, 'fee' => 600],
        ['term' => 24, 'amount' => 16000, 'fee' => 640],
        ['term' => 24, 'amount' => 17000, 'fee' => 680],
        ['term' => 24, 'amount' => 18000, 'fee' => 720],
        ['term' => 24, 'amount' => 19000, 'fee' => 760],
        ['term' => 24, 'amount' => self::MAX_AMOUNT_TO_LOAN, 'fee' => 800],
    ];

    public function getFeesForTerm(int $term): array
    {
        return array_values(array_filter(array_map(
            static function ($fee) use ($term) {
                if ($fee['term'] === $term) {
                    return [
                        'amount' => $fee['amount'],
                        'fee' => $fee['fee'],
                    ];
                }
            },
            self::$valueMap
        )));
    }
}
