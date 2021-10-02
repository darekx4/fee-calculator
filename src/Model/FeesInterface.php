<?php

declare(strict_types=1);

namespace Darekx4\Fee\Calculator\Model;

interface FeesInterface
{
    public function getFeesForTerm(int $term): array;
}
