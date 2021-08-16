<?php

class Rgb {
    public $r, $g, $b, $alpha;
    private Rgb $background;
    public function __construct($r, $g, $b, $alpha)
    {
        [$this->r, $this->g, $this->b, $this->alpha] = [$r, $g, $b, $alpha];
    }

    public function setBackgroundColor(Rgb $rgb)
    {
        $this->background = $rgb;
    }

    public function blend() : Rgb
    {
        $blendedR = ((1 - $this->alpha) * $this->background->r) + ($this->alpha * $this->r);
        $blendedG = ((1 - $this->alpha) * $this->background->g) + ($this->alpha * $this->g);
        $blendedB = ((1 - $this->alpha) * $this->background->b) + ($this->alpha * $this->b);
        return new Rgb($blendedR, $blendedG, $blendedB, 1.0);
    }

    public function __toString()
    {
        return sprintf("rgba(%3d,%3d,%3d,%4f)", $this->r, $this->g, $this->b, $this->alpha);
    }


}

$baseColor = new Rgb(61, 181, 241, .6);
$bg = new Rgb(255, 255, 0, 1.0);
$baseColor->setBackgroundColor($bg);
$mixedColor = $baseColor->blend();

echo '<div style="width: 100px; height: 100px; background-color: '.$baseColor.';">base</div>';
echo '<div style="width: 100px; height: 100px; background-color: '.$bg.';">background</div>';
echo '<div style="width: 100px; height: 100px; background-color: '.$mixedColor.';">blend</div>';