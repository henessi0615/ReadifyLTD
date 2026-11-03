<?php

declare(strict_types=1);

namespace App\Service\Book;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

final readonly class MoneyParser
{
    private DecimalMoneyParser $parser;

    public function __construct()
    {
        $this->parser = new DecimalMoneyParser(new ISOCurrencies());
    }

    public function createFromString(string $amount, string $currency): Money
    {
        return $this->parser->parse($amount, new Currency($currency));
    }
}
