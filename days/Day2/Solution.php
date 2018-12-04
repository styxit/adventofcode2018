<?php

namespace Days\Day2;

use Styxit\AbstractSolution;

class Solution extends AbstractSolution
{
    public function execute()
    {
        $two = 0;
        $three = 0;

        foreach ($this->input->lines as $lineNr => $line) {
            $countedCharacters = $this->countCharacters($line);

            $two += $countedCharacters[2];
            $three += $countedCharacters[3];

            /*
             * Part 2 requires two lines that differ exactly 1 character.
             * Compare the current line to all lines of the input to see if the diff is 1.
             */
            if (empty($this->part2)) {
                // Find a string that differs exactly 1 character.
                $matchingLine = $this->findMatch($line);

                // If a match was found the solution to part 2 can be set.
                if ($matchingLine !== false) {
                    /*
                     * These lines have a diff of 1 character, this is the key to the solution to part 2.
                     * Get the characters that are equal in the two strings and set as the solution to part 2.
                     */
                    $this->part2 = $this->getMatchingCharacters($line, $matchingLine);
                }

                // Remove the current line from the input so it is no longer used when doing the next levenshtein check.
                unset($this->input->lines[$lineNr]);
            }
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
        $characterCount = count_chars($input, 1);

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

    /**
     * Try to find a similar string in the input that differs exactly 1 character with $search.
     *
     * @param string $search The string to find a match for.
     *
     * @return false|string The matching string or false when no match.
     */
    private function findMatch(string $search)
    {
        foreach ($this->input->lines as $matchingLine) {
            // Calculate how many characters are different between two strings.
            $matchCount = levenshtein($search, $matchingLine);

            if ($matchCount === 1) {
                // This line has a diff of 1 character.
                return $matchingLine;
            }
        }

        return false;
    }

    /**
     * Get the characters that match in two strings. Filters out characters that are not in the same place across the
     * two string.
     *
     * Example;
     * If the input is `fghij` and `fguij` the characters that are in the same place are `fgij`.
     *
     * @param string $input1 First input.
     * @param string $input2 Second input.
     *
     * @return string The matching characters.
     */
    private function getMatchingCharacters(string $input1, string $input2): string
    {
        $matchingCharacters = '';

        // For each character in string 1, check if it appears on the same position in string 2.
        for ($i = 0; $i < strlen($input1); $i++) {
            if ($input1[$i] === $input2[$i]) {
                // Character is in the same spot, add it to the output.
                $matchingCharacters .= $input1[$i];
            }
        }

        return $matchingCharacters;
    }
}
