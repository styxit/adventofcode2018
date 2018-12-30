<?php

namespace Days\Day3;

use Styxit\AbstractSolution;

class Solution extends AbstractSolution
{
    /**
     * @var Canvas The canvas.
     */
    private $canvas;

    public function execute()
    {
        $this->part1 = 0;

        $this->canvas = new Canvas();

        foreach ($this->input->lines as $line) {
            $claim = new Claim($line);

            // Resize the canvas if the claim does not fit.
            $this->canvas->resizeCanvas($claim);

            // Mark the claimed area on the canvas.
            $this->canvas->mark($claim);
        }

        /*
         * Canvas is now filled with all claims.
         * Loop rows.
         */
        foreach($this->canvas->getGrid() as $row) {
            // Get all spots in the row that are claimed more than once.
            $overlappingClaimedSpotsInRow = array_filter($row, function($claims) {
                return $claims > 1;
            });

            $this->part1 += count($overlappingClaimedSpotsInRow);
        }

        /*
         * The solution to part 2 is to find the one claim that does not interfere with any other claim.
         * Check all claims on the canvas to see if it has no overlapping.
         */
        foreach ($this->input->lines as $line) {
            $claim = new Claim($line);

            // Check the claimed area.
            $unique = $this->canvas->checkUnique($claim);

            if ($unique) {
                $this->part2 = $claim->id;
                break;
            }
        }
    }
}
