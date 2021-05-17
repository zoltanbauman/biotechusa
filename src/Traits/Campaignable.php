<?php
namespace Biotech\Traits;

use Biotech\Models\Interfaces\CampaignInterface;

trait Campaignable
{
    protected CampaignInterface $campaign;

    public function setCampaign(CampaignInterface $campaign): void
    {
        $this->campaign = $campaign;
    }

    public function getCampaign(): CampaignInterface
    {
        return $this->campaign;
    }

    public function hasCampaign(): bool
    {
        return !is_null($this->campaign);
    }
}