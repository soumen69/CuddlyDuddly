<?php

namespace App\Domain\Catalog\Navigation\DTO;

final class MatchScore
{
    public function __construct(
        public int $masterCategoryId,
        public float $score = 0,
        public array $reasons = []
    ) {}

    public function add(
        float $score,
        string $reason
    ): void {
        $this->score += $score;

        if (! in_array($reason, $this->reasons, true)) {
            $this->reasons[] = $reason;
        }
    }
}
