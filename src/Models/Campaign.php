<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\CampaignableInterface;
use Biotech\Models\Interfaces\CampaignInterface;
use Biotech\Models\Interfaces\CouponInterface;
use Biotech\Models\Interfaces\PostInterface;
use Biotech\Models\Interfaces\ProductInterface;
use Biotech\Models\Interfaces\PublishableInterface;
use Biotech\Traits\Publishable;
use DateTime;
use Exception;

class Campaign extends BaseModel implements CampaignInterface, PublishableInterface
{
    use Publishable;

    protected DateTime $start;
    protected DateTime $finish;

    /**
     * @var array|PublishableInterface[]|CampaignableInterface[]
     */
    protected array $items = [];

    /**
     * @param DateTime|string|null $start
     * @throws Exception
     */
    public function setStart($start = null): void
    {
        $this->start = ($start instanceof DateTime) ? $start : new DateTime($start);
    }

    public function getStart(): DateTime
    {
        return $this->start;
    }

    /**
     * @param DateTime|string|null $finish
     * @throws Exception
     */
    public function setFinish($finish = null): void
    {
        $this->finish = ($finish instanceof DateTime) ? $finish : new DateTime($finish);
    }

    public function getFinish(): DateTime
    {
        return $this->finish;
    }

    protected function isStartable(): bool
    {
        return $this->getStart() <= $this->getDate();
    }

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