<?php
namespace Biotech\Models;

use Biotech\Models\Interfaces\CampaignInterface;
use Tests\TestCase;

class CampaignTest extends TestCase
{

    protected CampaignInterface $campaign;

    protected function setUp(): void
    {
        $this->campaign = new Campaign();
    }

    public function testCamapaignInstance()
    {
        $this->assertInstanceOf(CampaignInterface::class, $this->campaign);
        $this->assertFalse($this->campaign->isPublished());
    }

    public function testPublish()
    {
        $this->campaign->publish();

        $this->assertTrue($this->campaign->isPublished());
    }
}