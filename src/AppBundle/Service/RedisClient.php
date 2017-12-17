<?php

declare(strict_types = 1);

namespace AppBundle\Service;

class RedisClient
{
    /**
     * @var \Redis
     */
    private $client;

    /**
     * @param string $host
     *
     * @throws \RedisException
     */
    public function __construct(string $host)
    {
        $this->client = new \Redis();

        if (!$this->client->connect($host)) {
            throw new \RedisException('Unable to connect: ' . $host);
        }
    }

    /**
     * @param string $key
     *
     * @return bool|string
     */
    public function get(string $key)
    {
        return $this->client->get($key);
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $ttl
     */
    public function set(string $key, string $value, int $ttl): void
    {
        $this->client->setex($key, $ttl, $value);
    }
}
