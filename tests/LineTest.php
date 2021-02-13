<?php


use Dotenv\Dotenv;
use Phattarachai\LineNotify\Line;


class LineTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Line
     */
    protected Line $line;

    protected function setUp(): void
    {
        parent::setUp();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $this->line = new Line($_ENV['LINE_ACCESS_TOKEN']);
    }

    public function test_send_message()
    {
        $this->line->send('ทดสอบ');
        self::assertTrue(true);
    }

    public function test_send_image_from_url_with_thumbnail_url()
    {
        $this->line->thumbnailUrl('https://phattarachai.dev/images/logo-purple.png')
            ->imageUrl('https://me.phattarachai.dev/wp-content/uploads/2021/02/laravel8-1.jpg')
            ->send('ข้อความ, thumbnail, และ Image');

        self::assertTrue(true);
    }

    public function test_send_image_from_url_without_thumbnail_url()
    {
        $this->line->imageUrl('https://me.phattarachai.dev/wp-content/uploads/2021/02/laravel8-1.jpg')
            ->send('ข้อความ และ Image');

        self::assertTrue(true);
    }

    public function test_upload_image()
    {
        $this->line->imagePath(__DIR__ . '/../art/line-notify-banner.jpg')
            ->send('ข้อความ และ Upload Image');

        self::assertTrue(true);
    }

    public function test_send_sticker()
    {
        $this->line->sticker(1, 138)
            ->send('ข้อความ และ Sticker');

        self::assertTrue(true);
    }

    public function test_disable_notification()
    {
        $this->line->disableNotification()
            ->send('ข้อความไม่แจ้งเตือน');

        self::assertTrue(true);
    }

}
