<?php
namespace Biotech\Models\Interfaces;

interface CampaignInterface
{
    public function addCampaignItem(CampaignableInterface $campaignItem): void;
    public function getCampaignItems(): array;
}