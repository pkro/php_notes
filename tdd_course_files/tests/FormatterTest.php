<?php

namespace TDD\Test;
require dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Formatter;

class FormatterTest extends TestCase
{
    public Formatter $formatter;

    public function setUp(): void
    {
        $this->formatter = new Formatter();
    }

    /**
     * @dataProvider provideTwoDecimals
     */
    public function testCurrencyAmount($input, $expected)
    {
        $result = $this->formatter->currencyAmount($input);
        $this->assertSame($expected, $result, "{$input} should be converted to {$expected}");
    }

    public function provideTwoDecimals(): array
    {
        return [
            [1, 1.00],
            [1.1, 1.10],
            [1.11, 1.11],
            [1.111, 1.11],
        ];
    }

    public function tearDown(): void
    {
        unset($this->formatter);
    }
}