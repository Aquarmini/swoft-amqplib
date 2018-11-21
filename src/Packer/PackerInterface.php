<?php


namespace Swoftx\Amqplib\Packer;


interface PackerInterface
{
    public function pack($data): string;

    public function unpack(string $data);
}