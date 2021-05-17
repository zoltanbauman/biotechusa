<?php
namespace Biotech\Models;

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

    /**
     * @var array|PublishableInterface[]|CampaignableInterface[]
     */
    protected array $items = [];

    public function isPublishable(): bool
    {
        if (empty($this->items)) return false;

        foreach ($this->items as $item) {
            if ($item->hasPublishedCampaign() OR !$item->isPublishable()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param CampaignableInterface ...$campaignItems
     */
    public function addCampaignItem(CampaignableInterface ...$campaignItems): void
    {
        foreach ($campaignItems as $campaignItem) {
            if (!$this->hasCampaignItem($campaignItem)) {
                $campaignItem->addCampaign($this);
                $this->items[] = $campaignItem;
            }
        }
    }

    /**
     * @return array|CampaignableInterface[]
     */
    public function getCampaignItems(): array
    {
        return $this->items;
    }

    /**
     * @param CampaignableInterface|BaseModel $campaignItem
     * @return bool
     */
    public function hasCampaignItem(CampaignableInterface $campaignItem): bool
    {
        foreach ($this->items as $item) {
            if ((get_class($item) == get_class($campaignItem)) AND ($item->getId() == $campaignItem->getId())) return true;
        }

        return false;
    }

    /**
     * @param ProductInterface|CampaignableInterface $product
     */
    public function addProduct(ProductInterface $product): void
    {
        $this->addCampaignItem($product);
    }

    /**
     * @param CouponInterface|CampaignableInterface $coupon
     */
    public function addCoupon(CouponInterface $coupon): void
    {
        $this->addCampaignItem($coupon);
    }

    /**
     * @param PostInterface|CampaignableInterface $post
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