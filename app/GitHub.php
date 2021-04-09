<?php

namespace ZTT\app;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\InvalidArgumentException;
use GuzzleHttp\Exception\RequestException;

class GitHub
{
    const URL = 'https://api.github.com';
    protected $method;
    /** @var Client */
    protected $client;

    /**
     * GitHub constructor.
     * @throws GuzzleException
     */
    public function __construct()
    {
        $this->method = self::URL;
        $this->connect();
    }

    /**
     * Connect with Guzzle client
     *
     * @throws InvalidArgumentException
     */
    private function connect()
    {
        try {
            $this->client = new Client(
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'base_uri' => self::URL,
                ]
            );
        } catch (InvalidArgumentException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = self::URL . $method;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @return string
     * @throws GuzzleException
     */
    public function getGetData(): string
    {
        try {
            $data = $this->client->get($this->method);
            return $data->getBody();
        } catch (RequestException $exception) {
            throw new RequestException($exception->getMessage());
        }
    }
}
