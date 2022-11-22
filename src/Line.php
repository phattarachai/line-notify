<?php


namespace Phattarachai\LineNotify;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Line
{
    protected Client $client;
    protected ?string $token;
    protected ?string $imageUrl = null;
    protected ?string $imagePath = null;
    protected ?string $stickerId = null;
    protected ?string $thumbnailUrl = null;
    protected ?string $stickerPackageId = null;
    protected bool $notificationDisabled = false;

    public const URL = 'https://notify-api.line.me/api/notify';

    public function __construct(?string $token = null)
    {
        $this->client = new Client(['verify' => false]);
        $this->token = $token;
    }

    /**
     * Set token Line notify that want to send message
     *
     * @param string $token the token of Line notify
     */
    public function setToken(string $token): Line
    {
        $this->token = $token;
        return $this;
    }

    public function thumbnailUrl(string $url): Line
    {
        $this->thumbnailUrl = $url;
        return $this;
    }

    public function imageUrl(string $url): Line
    {
        $this->imageUrl = $url;
        return $this;
    }

    public function imagePath(string $path): Line
    {
        $this->imagePath = $path;
        return $this;
    }

    public function sticker(int $sticker_package_id, int $sticker_id): Line
    {
        $this->stickerPackageId = $sticker_package_id;
        $this->stickerId = $sticker_id;

        return $this;
    }

    public function disableNotification(): Line
    {
        $this->notificationDisabled = true;
        return $this;
    }

    public function enableNotification(): Line
    {
        $this->notificationDisabled = false;
        return $this;
    }

    /**
     * Send Line text message.
     *
     * @param string $message text message on Line notify can not be empty
     * @return boolean success or fail on send Line notify message
     * @throws GuzzleException|\JsonException
     */
    public function send(string $message): bool
    {
        $response = $this->client->request('POST', static::URL, $this->params($message));

        return $this->isSuccess($response);
    }

    /**
     * @param ResponseInterface $response
     * @return bool
     * @throws \JsonException
     */
    protected function isSuccess(ResponseInterface $response): bool
    {
        $json = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return isset($json['status']) && $json['status'] === 200;
    }

    /**
     * @param string $message
     * @return array
     */
    protected function params(string $message): array
    {
        if ($this->token === null) {
            throw new \Exception('Please specify line-notify access token');
        }

        return [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
            'multipart' => $this->multipartParams($message)
        ];
    }

    private function multipartParams(string $message)
    {

        $multipart = [
            [
                'name' => 'message',
                'contents' => $message
            ],
            [
                'name' => 'notificationDisabled',
                'contents' => $this->notificationDisabled ? 1 : 0
            ]
        ];

        if ($this->imagePath !== null) {

            $multipart[] = [
                'name' => 'imageFile',
                'contents' => fopen($this->imagePath, 'r')
            ];

        }

        if ($this->imageUrl !== null) {

            $multipart[] = [
                'name' => 'imageThumbnail',
                'contents' => $this->thumbnailUrl ?? $this->imageUrl
            ];

            $multipart[] = [
                'name' => 'imageFullsize',
                'contents' => $this->imageUrl
            ];
        }

        if ($this->stickerId !== null) {

            $multipart[] = [
                'name' => 'stickerPackageId',
                'contents' => $this->stickerPackageId
            ];

            $multipart[] = [
                'name' => 'stickerId',
                'contents' => $this->stickerId
            ];
        }

        return $multipart;
    }

}
