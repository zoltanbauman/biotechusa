<?php
namespace Biotech\Models;

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
        $product = (new Product())->setId(1);
        $product2 = (new Product())->setId(2);
        $coupon = (new Coupon())->setId(1);
        $post = (new BlogPost())->setId(1);

        $this->campaign->addProduct($product);
        $this->campaign->addCoupon($coupon);
        $this->campaign->addPost($post);
        $this->campaign->addCampaignItem($product2);

        $this->assertCount(4, $this->campaign->getCampaignItems());
        $this->assertEquals($product2->getId(), $this->campaign->getProducts()[1]->getId());
    }

    public function testSuccessCampaignPublish()
    {
        $product = (new Product())->setId(1);
        $coupon = (new Coupon())->setId(1);
        $post = (new BlogPost())->setId(1);

        $this->campaign->addCampaignItem($product, $coupon, $post);

        $this->getDateMocker(__NAMESPACE__, "2");

        $this->campaign->publish();

        $this->assertTrue($this->campaign->isPublished());
    }

    public function testMultipleCampaignUsedItems()
    {
        $product = (new Product())->setId(1);
        $coupon = (new Coupon())->setId(1);
        $post = (new BlogPost())->setId(1);

        $campaign2 = new Campaign();

        $this->campaign->addCampaignItem($product, $coupon, $post);
        $campaign2->addCampaignItem($product, $coupon, $post);

        $this->assertEquals($this->campaign->getCampaignItems(), $campaign2->getCampaignItems());
    }

    /**
     * A kampányok futtatásának feltétele, hogy jóváhagyott státuszban legyenek
     */
    public function testPublishableWithItems()
    {
        $product = (new Product())->setId(1);
        $coupon = (new Coupon())->setId(1);
        $post = (new BlogPost())->setId(1);

        $this->campaign->addProduct($product);
        $this->assertTrue($this->campaign->isPublishable());

        $this->getDateMocker(__NAMESPACE__, "3");
        $this->campaign->addPost($post);
        $this->assertTrue($this->campaign->isPublishable());

        $this->campaign->addCoupon($coupon);
        $this->assertTrue($this->campaign->isPublishable());
    }

    /**
     * Nem futhat két kampány egyidőben, ugyanazokra az elemekre
     *
     * @throws NotPublishableException
     */
    public function testNotPublishableWithMultipleCampaign()
    {
        $this->getDateMocker(__NAMESPACE__, "3")->disable();
        $product = (new Product())->setId(1);

        $this->campaign->addCampaignItem($product);
        $this->campaign->publish();

        $this->expectException(NotPublishableException::class);
        $campaign2 = new Campaign();
        $campaign2->addCampaignItem($product);
        $campaign2->publish();
    }

/*
    public function testCampaignItemUsed()
    {
        $product = new Product(['id' => 1]);
        $this->campaign->addProduct($product);

        $this->expectException(CampaignItemAlreadyUsedException::class);

        $campaign2 = new Campaign();
        $campaign2->addProduct($product);
    }
*/
}