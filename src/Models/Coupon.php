<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\CampaignableInterface;
use Biotech\Models\Interfaces\CouponInterface;
use Biotech\Models\Interfaces\PublishableInterface;
use Biotech\Traits\Campaignable;
use Biotech\Traits\Publishable;
use DateTime;

class Coupon extends BaseModel implements CouponInterface, PublishableInterface, CampaignableInterface
{
    use Publishable;
    use Campaignable;

    public function isPublishable(): bool
    {
        $date = new DateTime();
        $thirdDayOfMonth = (new DateTime())->modify("first day of this month")->modify("+3days")->modify("midnight");
        $lastThreeDayOfMonth = (new DateTime())->modify("last day of this month")->modify("-2days")->modify("midnight");

        return ($date > $thirdDayOfMonth) AND ($date < $lastThreeDayOfMonth);
    }
}