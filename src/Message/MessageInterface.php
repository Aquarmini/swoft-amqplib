<?php


namespace Swoftx\Amqplib\Message;


interface MessageInterface
{
    /**
     * 推送消息
     * @author limx
     * @return mixed
     */
    public function publish();

    /**
     * 声明Exchange、Queue
     * @author limx
     * @return mixed
     */
    public function declare();

    /**
     * 获取消息内容
     * @author limx
     * @return mixed
     */
    public function message();
}