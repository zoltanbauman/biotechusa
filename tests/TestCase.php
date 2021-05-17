<?php
namespace Tests;

use Biotech\Models\BlogPost;
use Biotech\Models\Coupon;
use PHPUnit\Framework\TestCase as UnitTestCase;

abstract class TestCase extends UnitTestCase
{
    public function getCouponMock()
    {
        return $this->getMockBuilder(Coupon::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDate', 'setId', 'getId'])
            ->getMock();
    }

    public function getBlogPostMock()
    {
        return $this->getMockBuilder(BlogPost::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDate', 'setId', 'getId'])
            ->getMock();
    }
}