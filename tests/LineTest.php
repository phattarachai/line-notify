<?php


use Dotenv\Dotenv;
use Phattarachai\LineNotify\Line;
use PHPUnit\Framework\TestCase;


class LineTest extends TestCase
{

    protected Line $line;

    protected function setUp(): void
    {
        parent::setUp();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $this->line = new Line($_ENV['LINE_ACCESS_TOKEN']);
    }

    public function test_send_message(): void
    {
        $this->line->send('ทดสอบ');
        self::assertTrue(true);
    }

    public function test_send_image_from_url_with_thumbnail_url(): void
    {
        $this->line->thumbnailUrl('https://phattarachai.dev/images/logo-purple.png')
            ->imageUrl('https://me.phattarachai.dev/wp-content/uploads/2021/02/laravel8-1.jpg')
            ->send('ข้อความ, thumbnail, และ Image');

        self::assertTrue(true);
    }

    public function test_send_image_from_url_without_thumbnail_url(): void
    {
        $this->line->imageUrl('https://me.phattarachai.dev/wp-content/uploads/2021/02/laravel8-1.jpg')
            ->send('ข้อความ และ Image');

        self::assertTrue(true);
    }

    public function test_upload_image(): void
    {
        $this->line->imagePath(__DIR__ . '/../art/line-notify-banner.jpg')
            ->send('ข้อความ และ Upload Image');

        self::assertTrue(true);
    }

    public function test_send_sticker(): void
    {
        $this->line->sticker(1, 138)
            ->send('ข้อความ และ Sticker');

        self::assertTrue(true);
    }

    public function test_disable_notification(): void
    {
        $this->line->disableNotification()
            ->send('ข้อความไม่แจ้งเตือน');

        self::assertTrue(true);
    }

}
