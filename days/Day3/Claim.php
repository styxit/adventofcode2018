<?php

namespace Days\Day3;

class Claim
{
    public $id = 0;

    public $left = 0;
    public $top = 0;

    public $width = 0;
    public $height = 0;

    public function __construct($claim)
    {
        $claim = preg_split("/\D+/", $claim);

        $this->id = $claim[1];

        $this->left = $claim[2];
        $this->top = $claim[3];

        $this->width = $claim[4];
        $this->height = $claim[5];
    }
}
