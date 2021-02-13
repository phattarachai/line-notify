<?php


namespace Phattarachai\LineNotify;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Line
{
    protected Client $client;
    protected string $token;
    protected ?string $thumbnailUrl = null;
    protected ?string $imageUrl = null;
    protected bool $notificationDisabled = false;
    protected ?int $stickerPackageId = null;
    protected ?int $stickerId = null;

    const URL = 'https://notify-api.line.me/api/notify';

    public function __construct(string $token = '')
    {
        $this->client = new Client;
        $this->token = $token;
    }

    /**
     * Set token Line notify that want to send message
     *
     * @param string $token the token of Line notify
     */
    public function setToken(string $token)
    {
        $this->token = $token;
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

    public function sticker(int $sticker_package_id, int $sticker_id)
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
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return bool
     * @throws \JsonException
     */
    protected function isSuccess(\Psr\Http\Message\ResponseInterface $response): bool
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
