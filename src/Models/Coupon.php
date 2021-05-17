<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\CampaignableInterface;
use Biotech\Models\Interfaces\CouponInterface;
use Biotech\Models\Interfaces\PublishableInterface;
use Biotech\Traits\Campaignable;
use Biotech\Traits\Publishable;
use DateTime;
use Exception;

class Coupon extends BaseModel implements CouponInterface, PublishableInterface, CampaignableInterface
{
    use Publishable;
    use Campaignable;

    public function isPublishable(): bool
    {
        $date = $this->getDate();
        $thirdDayOfMonth = (clone $date)->modify("first day of this month")->modify("+3days")->modify("midnight");
        $lastThreeDayOfMonth = (clone $date)->modify("last day of this month")->modify("-2days")->modify("midnight");

        print_r($date);
        print_r($thirdDayOfMonth);
        print_r($lastThreeDayOfMonth);

        return ($date > $thirdDayOfMonth) AND ($date < $lastThreeDayOfMonth);
    }

    /**
     * @param string|null $time
     * @return DateTime
     * @throws Exception
     */
    public function getDate(?string $time = null): DateTime
    {
        return new DateTime($time);
    }
}