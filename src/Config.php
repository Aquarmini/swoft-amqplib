<?php


namespace Swoftx\Amqplib;


class Config
{
    protected $host;
    protected $port;
    protected $user;
    protected $password;
    protected $vhost;

    public function __construct($host = '127.0.0.1', $port = 5672, $user = 'guest', $password = 'guest', $vhost = '/')
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->vhost = $vhost;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getVhost(): string
    {
        return $this->vhost;
    }
}