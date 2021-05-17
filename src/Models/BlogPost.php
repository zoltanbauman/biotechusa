<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\CampaignableInterface;
use Biotech\Models\Interfaces\PostInterface;
use Biotech\Models\Interfaces\PublishableInterface;
use Biotech\Traits\Campaignable;
use Biotech\Traits\Publishable;

class BlogPost extends BaseModel implements PostInterface, PublishableInterface, CampaignableInterface
{
    use Publishable;
    use Campaignable;

    public function isPublishable(): bool
    {
        return ($this->getDate()->format("N") < 6);
    }
}