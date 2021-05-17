<?php
namespace Biotech\Models\Interfaces;

interface CampaignableInterface
{
    public function setCampaign(CampaignInterface $campaign): void;
    public function getCampaign(): CampaignInterface;
    public function hasCampaign(): bool;
}