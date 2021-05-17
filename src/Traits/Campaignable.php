<?php
namespace Biotech\Traits;

use Biotech\Models\Campaign;
use Biotech\Models\Interfaces\CampaignInterface;
use Biotech\Models\Interfaces\PublishableInterface;

trait Campaignable
{
    /**
     * @var CampaignInterface[]|PublishableInterface[]|Campaign[]
     */
    protected array $campaigns = [];

    public function addCampaign(CampaignInterface $campaign): void
    {
        if (!$this->hasCampaign($campaign)) {
            $this->campaigns[] = $campaign;
        }
    }

    public function getCampaigns(): array
    {
        return $this->campaigns;
    }

    /**
     * @param CampaignInterface|Campaign|null $campaign
     * @return bool
     */
    public function hasCampaign(CampaignInterface $campaign = null): bool
    {
        foreach ($this->campaigns as $campaignElement) {
            if ($campaignElement->getId() == $campaign->getId()) return true;
        }
        return false;
    }

    public function hasPublishedCampaign(): bool
    {
        foreach ($this->campaigns as $campaign) {
            if ($campaign->isPublished()) return true;
        }
        return false;
    }
}