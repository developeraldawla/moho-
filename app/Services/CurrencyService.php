<?php
namespace App\Services;

class CurrencyService
{
    public function getExchangeRate($from, $to)
    {
        // Mock implementation
        return 1.0;
    }
    public function convert($amount, $from, $to)
    {
        return $amount * $this->getExchangeRate($from, $to);
    }
    public function getFormattedPrice($amount, $currency)
    {
        return $currency . ' ' . number_format($amount, 2);
    }
}
