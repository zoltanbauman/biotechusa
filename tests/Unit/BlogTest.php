<?php
namespace Biotech\Models;

use Biotech\Exceptions\NotPublishableException;
use Biotech\Models\Interfaces\PostInterface;
use phpmock\phpunit\PHPMock;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use PHPMock;

    protected BlogPost $blogPost;

    protected function setUp(): void
    {
        $this->blogPost = new BlogPost();
    }

    public function testBlogPostInstance()
    {
        $this->assertInstanceOf(PostInterface::class, $this->blogPost);
        $this->assertFalse($this->blogPost->isPublished());
    }

    public function testPublish()
    {
        $dateMock = $this->getDateMocker(__NAMESPACE__,1);

        $this->blogPost->publish();

        $this->assertTrue($this->blogPost->isPublished());

        $dateMock->disable();
    }

    public function testNotPublishableException()
    {
        $this->expectException(NotPublishableException::class);

        $dateMocker = $this->getDateMocker(__NAMESPACE__, "6");

        $this->blogPost->publish();

        $dateMocker->disable();
    }
}