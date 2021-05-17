<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\CampaignInterface;
use Biotech\Models\Interfaces\PublishableInterface;
use Biotech\Traits\Publishable;

class Campaign extends BaseModel implements CampaignInterface, PublishableInterface
{
    use Publishable;

    public function isPublishable(): bool
    {
        return true;
    }
}