<?php
namespace Biotech\Models;

use Biotech\Exceptions\CampaignItemAlreadyUsedException;
use Biotech\Models\Interfaces\CampaignableInterface;
use Biotech\Models\Interfaces\CampaignInterface;
use Biotech\Models\Interfaces\CouponInterface;
use Biotech\Models\Interfaces\PostInterface;
use Biotech\Models\Interfaces\ProductInterface;
use Biotech\Models\Interfaces\PublishableInterface;
use Biotech\Traits\Publishable;

class Campaign extends BaseModel implements CampaignInterface, PublishableInterface
{
    use Publishable;

    protected array $items = [];

    public function isPublishable(): bool
    {
        if (empty($this->items)) return false;

        return true;
    }

    /**
     * @param CampaignableInterface $campaignItem
     * @throws CampaignItemAlreadyUsedException
     */
    public function addCampaignItem(CampaignableInterface $campaignItem): void
    {
        if ($campaignItem->hasCampaign()) {
            throw new CampaignItemAlreadyUsedException();
        }
        $campaignItem->setCampaign($this);
        $this->items[] = $campaignItem;
    }

    /**
     * @return array|CampaignableInterface[]
     */
    public function getCampaignItems(): array
    {
        return $this->items;
    }

    /**
     * @param ProductInterface|CampaignableInterface $product
     * @throws CampaignItemAlreadyUsedException
     */
    public function addProduct(ProductInterface $product): void
    {
        $this->addCampaignItem($product);
    }

    /**
     * @param CouponInterface|CampaignableInterface $coupon
     * @throws CampaignItemAlreadyUsedException
     */
    public function addCoupon(CouponInterface $coupon): void
    {
        $this->addCampaignItem($coupon);
    }

    /**
     * @param PostInterface|CampaignableInterface $post
     * @throws CampaignItemAlreadyUsedException
     */
    public function addPost(PostInterface $post): void
    {
        $this->addCampaignItem($post);
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return array_values(array_filter($this->items, function(CampaignableInterface $item) {
            return $item instanceof ProductInterface;
        }));
    }

    /**
     * @return array
     */
    public function getCoupons(): array
    {
        return array_values(array_filter($this->items, function(CampaignableInterface $item) {
            return $item instanceof CouponInterface;
        }));
    }

    /**
     * @return array
     */
    public function getPosts(): array
    {
        return array_values(array_filter($this->items, function(CampaignableInterface $item) {
            return $item instanceof PostInterface;
        }));
    }
}