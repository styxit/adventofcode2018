<?php

namespace Days\Day1;

use Styxit\AbstractSolution;

class Solution extends AbstractSolution
{
    /**
     * @var int Calculated frequency, starts at 0.
     */
    private $frequency = 0;

    /**
     * @var int[] Keep track of all frequencies found.
     */
    private $frequencies = [];

    /**
     * Find the solution.
     */
    public function execute()
    {
        // Calculate frequencies once to get the solution to part 1.
        $this->calculateFrequency(false);
        // Set the final number as solution for part 1.
        $this->part1 = $this->frequency;

        // Keep calculating frequencies until a duplicate has been found.
        while (true) {
            $duplicateFrequency = $this->calculateFrequency(true);

            if ($duplicateFrequency !== false) {
                break;
            }
        }

        // A duplicate has been found, this is the solution to part 2.
        $this->part2 = $duplicateFrequency;
    }

    /**
     * Just sum all lines from the input.
     * Lines start with `-` or `+` to indicate increase or decrease.
     *
     * @param bool $returnOnDuplicate When true will return the frequency as soon as the same frequency was already
     *                                found earlier.
     *
     * @return int|false A duplicate value when found, false when no duplicate was found or $returnOnDuplicate was false.
     */
    private function calculateFrequency($returnOnDuplicate = false)
    {
        foreach ($this->input->lines as $line) {
            // First character determines increase or decrease.
            $method = substr($line, 0, 1);
            $number = (int) substr($line, 1);

            if ($method == '+') {
                $this->frequency += $number;
            } elseif ($method == '-') {
                $this->frequency -= $number;
            }

            /*
             * Add the new frequency to the list of found frequencies if not already there.
             * Use array keys instead of values to make search faster.
             *
             * Immediately return frequency when looking for duplicates and the found frequency has been found before.
             */
            if (!isset($this->frequencies[$this->frequency])) {
                $this->frequencies[$this->frequency] = true;
            } elseif ($returnOnDuplicate === true) {
                return $this->frequency;
            }
        }

        return false;
    }
}
