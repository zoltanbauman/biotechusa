<?php
namespace Biotech\Models\Interfaces;

interface CampaignInterface
{
    public function setStart($start = null): void;
    public function setFinish($finish = null): void;

    public function addCampaignItem(CampaignableInterface ...$campaignItems): void;
    public function getCampaignItems(): array;
    public function hasCampaignItem(CampaignableInterface $campaignItem): bool;
}