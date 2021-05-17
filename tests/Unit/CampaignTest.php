<?php
namespace Biotech\Models;

use Biotech\Exceptions\CampaignItemAlreadyUsedException;
use Biotech\Exceptions\NotPublishableException;
use Biotech\Models\Interfaces\CampaignInterface;
use Tests\TestCase;

class CampaignTest extends TestCase
{

    protected CampaignInterface $campaign;

    protected function setUp(): void
    {
        $this->campaign = new Campaign();
    }

    public function testCamapaignInstance()
    {
        $this->assertInstanceOf(CampaignInterface::class, $this->campaign);
        $this->assertFalse($this->campaign->isPublished());
    }

    public function testPublishOnEmptyItems()
    {

        $this->expectException(NotPublishableException::class);

        $this->campaign->publish();
    }

    public function testAddCampaignItems()
    {
        $product = new Product(['id' => 1]);
        $product2 = new Product(['id' => 2]);
        $coupon = new Coupon(['id' => 1]);
        $post = new BlogPost(['id' => 1]);

        $this->campaign->addProduct($product);
        $this->campaign->addCoupon($coupon);
        $this->campaign->addPost($post);
        $this->campaign->addCampaignItem($product2);

        $this->assertCount(4, $this->campaign->getCampaignItems());
        $this->assertEquals($product2->id, $this->campaign->getProducts()[1]->id);
    }

    public function testCampaignItemUsed()
    {
        $product = new Product(['id' => 1]);
        $this->campaign->addProduct($product);

        $this->expectException(CampaignItemAlreadyUsedException::class);

        $campaign2 = new Campaign();
        $campaign2->addProduct($product);
    }
}