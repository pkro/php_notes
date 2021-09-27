<?php

namespace TDD;

class Receipt
{
    public float $tax;
    private Formatter $formatter;

    public function __construct(Formatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function subTotal(array $items = [], $coupon=0.0)
    {
        if ($coupon > 1.0) {
            throw new \BadMethodCallException("coupon value can't exceed 1.0 (=100%)");
        }
        $sum = array_sum($items);
        if (!is_null($coupon)) {
            $sum -= $sum * $coupon;
        }
        return $sum;
    }

    public function tax(float $inputAmount)
    {
        return $this->formatter->currencyAmount($inputAmount * $this->tax);
    }

    public function postTaxTotal(array $items, $coupon)
    {
        $subtotal = $this->subTotal($items, $coupon);
        return $subtotal + $this->tax($subtotal);
    }


}