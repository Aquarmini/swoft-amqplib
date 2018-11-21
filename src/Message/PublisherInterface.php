<?php


namespace Swoftx\Amqplib\Message;


interface PublisherInterface
{
    /**
     * 推送消息
     * @author limx
     * @return mixed
     */
    public function publish();
}