<?php
namespace Biotech\Traits;

use Biotech\Exceptions\NotPublishableException;
use DateTime;

trait Publishable
{
    protected bool $published = false;
    protected DateTime $publishedAt;

    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @throws NotPublishableException
     */
    public function publish(): void
    {
        if ( $this->isPublishable() ) {
            $this->published = true;
            $this->publishedAt = new DateTime();
        } else {
            throw new NotPublishableException();
        }
    }

    public function unPublish(): void
    {
        $this->published = false;
    }
}