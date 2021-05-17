<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\PostInterface;
use Biotech\Models\Interfaces\PublishableInterface;
use Biotech\Traits\Publishable;

class BlogPost extends BaseModel implements PostInterface, PublishableInterface
{
    use Publishable;

    public function isPublishable(): bool
    {
        return (date('N') < 6);
    }
}