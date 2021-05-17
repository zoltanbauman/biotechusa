<?php
namespace Biotech\Models;

use Biotech\Exceptions\NotPublishableException;
use Biotech\Models\Interfaces\PostInterface;
use phpmock\Mock;
use phpmock\MockBuilder;
use phpmock\phpunit\PHPMock;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use PHPMock;

    protected BlogPost $blogPost;

    protected function getDateMocker($dateText = '2021-05-22 10:00:00'): Mock
    {
        $builder = new MockBuilder();
        $builder->setNamespace(__NAMESPACE__);

        $builder->setName('date')
            ->setFunction(
                function() use ($dateText) {
                    return $dateText;
                }
            );
        $dateMock = $builder->build();
        $dateMock->enable();

        return $dateMock;
    }

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
        $dateMock = $this->getDateMocker(1);

        $this->blogPost->publish();

        $this->assertTrue($this->blogPost->isPublished());

        $dateMock->disable();
    }

    public function testNotPublishableException()
    {
        $this->expectException(NotPublishableException::class);

        $dateMocker = $this->getDateMocker("6");

        $this->blogPost->publish();

        $dateMocker->disable();
    }
}