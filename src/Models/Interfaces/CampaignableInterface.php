<?php
namespace Biotech\Models\Interfaces;

interface CampaignableInterface
{
    public function addCampaign(CampaignInterface $campaign): void;
    public function hasCampaign(CampaignInterface $campaign = null): bool;
    public function getCampaigns(): CampaignInterface;
}