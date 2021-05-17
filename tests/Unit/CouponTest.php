<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\CouponInterface;
use DateTime;
use Tests\TestCase;

class CouponTest extends TestCase
{
    protected CouponInterface $coupon;

    protected function setUp(): void
    {
        $this->coupon = new Coupon();
    }

    public function testProductInstance()
    {
        $this->assertInstanceOf(CouponInterface::class, $this->coupon);
        $this->assertFalse($this->coupon->isPublished());
    }

    /**
     * @throws \Exception
     * @dataProvider getDateProvider
     */
    public function testPublish($date, $result)
    {

        $couponMock = $this->getMockBuilder(Coupon::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDate'])
            ->getMock();

        $couponMock
            ->method('getDate')
            ->willReturn(new DateTime($date));

        $this->assertEquals($result, $couponMock->isPublishable());
    }

    public function getDateProvider(): array
    {
        return [
            ['2021-05-21', true],
            ['2021-05-03', false],
            ['2021-05-29', false],
        ];
    }
}