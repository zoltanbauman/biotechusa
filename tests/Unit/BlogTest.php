<?php
namespace Biotech\Models;

use Biotech\Exceptions\NotPublishableException;
use Biotech\Models\Interfaces\PostInterface;
use DateTime;
use Exception;
use Tests\TestCase;

class BlogTest extends TestCase
{

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

    /**
     * @param $date
     * @param $result
     * @throws Exception
     * @dataProvider getDateProvider
     */
    public function testPublish($date, $result)
    {
        $postMock = $this->getMockBuilder(BlogPost::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDate'])
            ->getMock();

        $postMock
            ->method('getDate')
            ->willReturn(new DateTime($date));

        $this->assertEquals($result, $postMock->isPublishable());
    }

    public function testNotPublishableException()
    {
        $postMock = $this->getMockBuilder(BlogPost::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getDate'])
            ->getMock();

        $postMock
            ->method('getDate')
            ->willReturn(new DateTime('2021-05-29'));

        $this->expectException(NotPublishableException::class);

        $postMock->publish();
    }

    public function getDateProvider(): array
    {
        return [
            ['2021-07-21', true],
            ['2021-07-02', true],
            ['2021-07-31', false],
        ];
    }
}