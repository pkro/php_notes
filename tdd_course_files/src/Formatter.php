<?php

namespace TDD;

class Formatter
{
    public function currencyAmount(float $decimal) {
        return  round($decimal, 2);
    }
}