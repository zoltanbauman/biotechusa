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
        $this->campaign->setStart('2021-05-01');
        $this->campaign->setFinish('2021-05-31');

        $this->assertSame('2021-05-01', $this->campaign->getStart()->format('Y-m-d'));
        $this->assertSame('2021-05-31', $this->campaign->getFinish()->format('Y-m-d'));
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

    /**
     * Engedélyezett egy elem több kampányban való jelenlét, amíg nincs publikálva a kampány
     */
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
     * Nem futhat két kampány egyidőben, ugyanazokra az elemekre
     *
     * @throws NotPublishableException
     */
    public function testNotPublishableWithMultipleCampaign()
    {
        $product = (new Product())->setId(1);

        $this->campaign->addCampaignItem($product);
        $this->campaign->publish();

        $this->expectException(NotPublishableException::class);
        $campaign2 = new Campaign();
        $campaign2->addCampaignItem($product);
        $campaign2->publish();
    }

    /**
     * A kampányok futtatásának feltétele, hogy jóváhagyott státuszban legyenek
     * @dataProvider getItemsProvider
     */
    public function testPublishableWithItems(string $date, bool $postResult, bool $couponResult)
    {
        $product = (new Product())->setId(1);
        $coupon = (new Coupon())->setId(1);
        $post = (new BlogPost())->setId(1);

        Campaign::setDate($date);

        $this->campaign->addProduct($product);
        $this->assertTrue($this->campaign->isPublishable());

        $this->campaign->addPost($post);
        $this->assertEquals($postResult, $this->campaign->isPublishable());

        $this->campaign->addCoupon($coupon);
        $this->assertEquals($couponResult, $this->campaign->isPublishable());

        $this->assertEquals($postResult&&$couponResult, $this->campaign->isPublishable());
    }

    public function getItemsProvider(): array
    {
        return [
            ['2021-05-21', true, true],
            ['2021-05-03', true, false],
            ['2021-05-29', false, false],
        ];
    }
}