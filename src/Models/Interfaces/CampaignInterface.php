<?php
namespace Biotech\Models\Interfaces;

interface CampaignInterface
{
    public function addCampaignItem(CampaignableInterface ...$campaignItems): void;
    public function getCampaignItems(): array;
    public function hasCampaignItem(CampaignableInterface $campaignItem): bool;
}