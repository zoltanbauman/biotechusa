<?php
namespace Biotech\Models\Interfaces;

interface PostInterface
{
    public function isPublished(): bool;
    public function publish();
}