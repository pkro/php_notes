<?php

namespace TDD\Test;
require dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use TDD\Formatter;
use TDD\Receipt;
use PHPUnit\Framework\TestCase;

class ReceiptTest extends TestCase
{
    private Receipt $receipt;
    private Formatter $formatter;

    public function setUp(): void
    {
        $this->formatter = $this->getMockBuilder('TDD\Formatter')
            ->onlyMethods(['currencyAmount'])
            ->getMock();
        $this->formatter->expects($this->any())
            ->method('currencyAmount')
            ->with($this->anything())
            ->will($this->returnArgument(0));


        $this->receipt = new Receipt($this->formatter);
    }

    public function tearDown(): void
    {
        unset($this->receipt);
    }

    //"simple" version
    /*public function testTotal()
    {
        $input = [0, 2, 5, 8];
        $coupon = null; // dummy object
        $expected = 15;
        $result = $this->receipt->total($input, $coupon);
        $this->assertEquals($expected, $result, 'Sum should equal 15');
    }*/

    // using a dataprovider

    /**
     * @dataProvider provideSubTotal
     */
    public function testSubTotal($input, $expected)
    {
        $coupon = null; // dummy object
        $result = $this->receipt->subTotal($input, $coupon);
        $this->assertEquals($expected, $result, 'Sum should equal ' . $expected);
    }

    public function provideSubTotal()
    {
        return [
            'ints should total 15' => [[0, 2, 5, 8], 15],
            [[0], 0],
            [[9999, 9999], 9999 + 9999]
        ];
    }

    public function testTotalWithCoupon()
    {
        $input = [0, 2, 5, 8];
        $coupon = 0.2;
        $expected = 12;
        $result = $this->receipt->subTotal($input, $coupon);
        $this->assertEquals($expected, $result, 'Sum should equal 15');
    }

    public function testTotalException()
    {
        $input = [0, 2, 5, 8];
        $coupon = 1.2;
        $this->expectException('BadMethodCallException');
        $this->receipt->subTotal($input, $coupon);
    }


    public function testTax()
    {
        $inputAmount = 10.0;
        $this->receipt->tax = 0.10;
        $result = $this->receipt->tax($inputAmount);
        $expected = 1.0;
        $this->assertEqualsWithDelta($expected, $result, 0.002, 'taxed amount should be ' . $expected);
    }

    // Stub version
    /*public function testPostTaxTotal() {
        $receipt = $this->getMockBuilder('TDD\Receipt')
            //addMethods for non existing methods, onlyMethods for existing methods
            ->onlyMethods(['tax', 'total'])
            ->getMock();
        $receipt->method('total') // define method output
            ->will($this->returnValue(10.00));
        $receipt->method('tax')
            ->will($this->returnValue(1.00));

        // the postTaxTotal method will now interlall use the mock methods above instead
        // of the ones defined in the class
        $result = $receipt->postTaxTotal([1,2,5,8], 0.2, null);
        $expected = 11.0;
        $this->assertEqualsWithDelta($expected, $result, 0.01, 'postTaxTotal amount should be '. $expected);
    }*/

    // Mock version


    public function testPostTaxTotal()
    {
        $items = [1, 2, 5, 8];
        $this->receipt->tax = 0.2;
        $coupon = null;

        $receipt = $this->getMockBuilder('TDD\Receipt')
            //addMethods for non existing methods, onlyMethods for existing methods
            ->onlyMethods(['tax', 'subTotal'])
            ->setConstructorArgs([$this->formatter])
            ->getMock();
        // expect this method to be called only once
        // other wise test fails
        // other arguments: never(), exactly(int amount), and more
        $receipt->expects($this->once())
            ->method('subTotal') // define method output
            ->with($items, $coupon) // (only) with this input
            ->will($this->returnValue(10.00)); // return this output

        $receipt->expects($this->once())
            ->method('tax')
            ->with(10.00)
            ->will($this->returnValue(1.00));

        // the postTaxTotal method will now interlall use the mock methods above instead
        // of the ones defined in the class
        $result = $receipt->postTaxTotal([1, 2, 5, 8], null);
        $expected = 11.0;
        $this->assertEqualsWithDelta($expected, $result, 0.01, 'postTaxTotal amount should be ' . $expected);
    }
}
