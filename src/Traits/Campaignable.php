<?php
namespace Biotech\Traits;

use Biotech\Models\Interfaces\CampaignInterface;

trait Campaignable
{
    /**
     * @var CampaignInterface
     */
    protected array $campaigns = [];

    public function addCampaign(CampaignInterface $campaign): void
    {
        if (!$this->hasCampaign($campaign)) {
            $this->campaigns[] = $campaign;
        }
    }

    public function getCampaigns(): CampaignInterface
    {
        return $this->campaigns;
    }

    public function hasCampaign(CampaignInterface $campaign = null): bool
    {
        return !is_null($this->campaigns);
    }
}