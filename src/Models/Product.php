<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\ProductInterface;
use Biotech\Traits\Publishable;

class Product extends BaseModel implements ProductInterface
{
    use Publishable;

    public function isPublishable(): bool
    {
        return true;
    }
}