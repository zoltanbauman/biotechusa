<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\ProductInterface;
use Tests\TestCase;

class ProductTest extends TestCase
{

    protected ProductInterface $product;

    protected function setUp(): void
    {
        $this->product = new Product();
    }

    public function testProductInstance()
    {
        $this->assertInstanceOf(ProductInterface::class, $this->product);
        $this->assertFalse($this->product->isPublished());
    }

    public function testPublish()
    {
        $this->product->publish();

        $this->assertTrue($this->product->isPublished());
    }
}