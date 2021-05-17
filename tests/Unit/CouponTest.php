<?php
namespace Biotech\Models;

use Biotech\Exceptions\NotPublishableException;
use Biotech\Models\Interfaces\CouponInterface;
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

    public function testPublish()
    {
        $coupon = $this->createMock(Coupon::class);
        $coupon->method('isPublishable')
            ->will($this->returnValue(true));
        $this->coupon->publish();
        $this->assertTrue($this->coupon->isPublished());
    }

    public function testNotPublishableException()
    {
        $coupon = $this->createMock(Coupon::class);
        $coupon->method('isPublishable')
            ->will($this->returnValue(false));

        $this->expectExceptionCode(NotPublishableException::class);

        $this->coupon->publish();
    }
}