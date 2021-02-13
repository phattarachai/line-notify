<?php


namespace Phattarachai\LineNotify;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Line
{

    protected $client;
    protected $token;

    const URL = 'https://notify-api.line.me/api/notify';

    public function __construct()
    {
        $this->client = new Client;

    }

    /**
     * Set token Line notify that want to send message
     *
     * @param string $token the token of Line notify
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Send text message, image or sticker on Line notify
     *
     * @param string $message text message on Line notify can not be empty
     * @return boolean success or fail on send Line notify message
     * @throws GuzzleException|\JsonException
     */
    public function send(string $message): bool
    {

        if (empty($message)) {
            return false;
        }

        $response = $this->client->request('POST', static::URL, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
            'multipart' => [
                [
                    'name' => 'message',
                    'contents' => $message
                ]
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException($response->getBody()->getContents());
        }

        $json = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return !(empty($json['status']) || empty($json['message']));
    }

}
