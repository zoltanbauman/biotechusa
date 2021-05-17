<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\ProductInterface;
use Biotech\Models\Interfaces\PublishableInterface;
use Biotech\Traits\Publishable;

class Product extends BaseModel implements ProductInterface, PublishableInterface
{
    use Publishable;

    public function isPublishable(): bool
    {
        return true;
    }
}