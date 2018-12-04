<?php

namespace Days\Day2;

use Styxit\AbstractSolution;

class Solution extends AbstractSolution
{
    public function execute()
    {
        $two = 0;
        $three = 0;

        foreach ($this->input->lines as $line) {
            $countedCharacters = $this->countCharacters($line);

            $two += $countedCharacters[2];
            $three += $countedCharacters[3];
        }

        // Multiply 2s and 3s as the solution to part one.
        $this->part1 = $two * $three;
    }

    /**
     * Check if there are characters that appear 2 or 3 times.
     *
     * Returns an array with the count and if a match was found or not.
     * Example:
     * [
     *   2 => 0
     *   3 => 1
     * ]
     * This means there was at leas one character count of 3, but none of 2.
     *
     * @param string $input The input to check.
     *
     * @return int[]
     */
    private function countCharacters($input)
    {
        // Count how many times all characters appear.
        $characterCount = count_chars ($input,1);

        // Filter list so only characters remain that appeared exactly 2 or 3 times.
        $filteredCharacterCount = array_filter($characterCount, function($count) {
            return $count === 2 || $count === 3;
        });

        // Return true for the number if there was at least one character appearing that many times.
        return [
            2 => array_search(2, $filteredCharacterCount) ? 1 : 0,
            3 => array_search(3, $filteredCharacterCount) ? 1 : 0,
        ];
    }
}
