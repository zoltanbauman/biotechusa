<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\CampaignableInterface;
use Biotech\Models\Interfaces\ProductInterface;
use Biotech\Models\Interfaces\PublishableInterface;
use Biotech\Traits\Campaignable;
use Biotech\Traits\Publishable;

class Product extends BaseModel implements ProductInterface, PublishableInterface, CampaignableInterface
{
    use Publishable;
    use Campaignable;

    public function isPublishable(): bool
    {
        return true;
    }
}