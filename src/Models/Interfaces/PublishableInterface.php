<?php
namespace Biotech\Models\Interfaces;

interface PublishableInterface
{
    /**
     * @return bool
     */
    public function isPublished(): bool;

    /**
     * @throw NotPublishableException
     */
    public function publish(): void;
    public function unPublish(): void;
    public function isPublishable(): bool;
}