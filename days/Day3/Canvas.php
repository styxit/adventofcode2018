<?php

namespace Days\Day3;

class Canvas
{
    private $columns = 0;

    private $grid = [];

    public function getGrid(){
      return $this->grid;
    }

    /**
     * Resize expand the canvas when needed so that a claim will fit on it.
     *
     * @param Claim $claim The claim to fit on the canvas.
     */
    public function resizeCanvas(Claim $claim)
    {
      // Canvas must be at least this wide.
      $width = $claim->width + $claim->left;
      $this->addColumns($width);

      // Canvas must be at least this high.
      $height = $claim->height + $claim->top;
      $this->addRows($height);
    }

    /**
     * Mark a claim on the canvas.
     *
     * @param Claim $claim The claim to mark on the canvas.
     */
    public function mark(Claim $claim) {
      $firstColumn = $claim->left;
      $lastColumn = $claim->left + $claim->width;

      $firstRow = $claim->top;
      $lastRow = $claim->top + $claim->height;

      // Claim rows on the canvas.
      for ($r = $firstRow; $r < $lastRow; $r++) {
        // Claim spots on the canvas.
        for ($c = $firstColumn; $c < $lastColumn; $c++) {
          // claim spot on the canvas.
          // Minus 1 sinces the grid has 0-based index.
          $this->grid[$r-1][$c] += 1;
        }
      }
    }

    /**
     * See if all spots in this claim are used only once.
     *
     * @param Claim $claim The claim to check.
     *
     * @return bool True when all spots are unique.
     */
    public function checkUnique(Claim $claim) {
        $firstColumn = $claim->left;
        $lastColumn = $claim->left + $claim->width;

        $firstRow = $claim->top;
        $lastRow = $claim->top + $claim->height;

        // Check rows on the canvas.
        for ($r = $firstRow; $r < $lastRow; $r++) {
            // Check spots in the row.
            for ($c = $firstColumn; $c < $lastColumn; $c++) {
                // Check a spot on the canvas.
                // Minus 1 sinces the grid has 0-based index.
                if (!isset($this->grid[$r-1][$c]) || $this->grid[$r-1][$c] !== 1) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Make sure the canvas has a minimum width.
     *
     * @param int $width The minimum width for all the rows.
     */
    private function addColumns(int $width)
    {
        // Figure out how many columns are missing.
        $missingcolumns = $width - $this->columns;

        if ($missingcolumns > 0) {
            $additionalColumns = array_fill(0, $missingcolumns, 0);

            // Add empty values to the end of each row.
            foreach($this->grid as $rowNr => $row) {
              $this->grid[$rowNr] = array_merge(
                  $row,
                  $additionalColumns
              );
            }

            $this->columns = $width;
      }
    }

    /**
     * Make sure the canvas has a specific height.
     *
     * @param int $height The minimum number of rows the canvas should have.
     */
    private function addRows(int $height)
    {
        // Figure out how many rows to add.
        $missingRows = $height - count($this->grid);

        if ($missingRows) {
            // Create an empty row.
            $additionalRow = array_fill(0, $this->columns, 0);

            // Keep adding empty rows until the right amount of rows is reached.
            for ($x = 1; $x <= $missingRows; $x++) {
                $this->grid[] = $additionalRow;
            }
        }
    }
}
