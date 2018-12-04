<?php

namespace Days\Day1;

use Styxit\AbstractSolution;

class Solution extends AbstractSolution
{
    public function execute()
    {
        /*
         * Just sum all lines from the input.
         * Lines start with `-` or `+` to indicate increase or decrease.
         */

        // Start at 0.
        $frequency = 0;

        foreach ($this->input->lines as $line) {
            // First character determines increase or decrease.
            $method = substr($line, 0, 1);
            $number = (int) substr($line, 1);

            if ($method == '+') {
                $frequency += $number;
            } elseif($method == '-') {
                $frequency -= $number;
            }
        }

        // Set the final number as solution for part 1.
        $this->part1 = $frequency;
    }
}
