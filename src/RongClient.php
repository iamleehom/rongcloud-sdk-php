<?php
// +----------------------------------------------------------------------
// | 融云服务端SDK-PHP
// +----------------------------------------------------------------------
// | Copyright (c) 2017~2018 LeeHom1988 All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://github.com/leehom1988/rongcloud-sdk-php/blob/1.x/LICENSE )
// +----------------------------------------------------------------------
// | Author: LeeHom1988 <lh411937409@gmail.com>
// +----------------------------------------------------------------------

namespace LeeHom\RongCloud;

use LeeHom\RongCloud\Module\User;
use LeeHom\RongCloud\Module\Group;
use LeeHom\RongCloud\Module\Message;
use LeeHom\RongCloud\Module\SMS;
use LeeHom\RongCloud\Module\Push;
use LeeHom\RongCloud\Module\SensitiveWord;
use LeeHom\RongCloud\Module\ChatRoom;
use GuzzleHttp\Client;

class RongClient
{
    // app version
    const   APP_VERSION = '1.0.3';
    //IM服务地址
    const   IM_API_URL = 'https://api-cn.ronghub.com';
    //短信服务地址
    const   SMS_API_URL = 'http://api.sms.ronghub.com';

    /**
     * 融云网络请求服务客户端
     *
     * @var \GuzzleHttp\Client Client
     */
    private $client;

    /**
     * 返回数据格式
     *
     * @var string $format
     */
    private $format;

    /**
     * RongCloud constructor.
     *
     * @param string $appKey
     * @param string $appSecret
     * @param string $format
     */
    public function __construct($appKey, $appSecret, $format = 'json')
    {
        $nonce     = mt_rand();
        $timeStamp = time();
        $sign      = sha1($appSecret . $nonce . $timeStamp);

        $this->client = new Client(['headers' => [
            'RC-app-Key'   => $appKey,
            'RC-Nonce'     => $nonce,
            'RC-Timestamp' => $timeStamp,
            'RC-Signature' => $sign
        ]]);
        $this->format = $format;
    }

    /**
     * @return \LeeHom\RongCloud\Module\User User
     */
    public function User()
    {
        $user = new User($this->client, self::IM_API_URL, $this->format);

        return $user;
    }

    /**
     * @return \LeeHom\RongCloud\Module\Message Message
     */
    public function Message()
    {
        $message = new Message($this->client, self::IM_API_URL, $this->format);

        return $message;
    }

    /**
     * @return \LeeHom\RongCloud\Module\SensitiveWord SensitiveWord
     */
    public function WordFilter()
    {
        $sensitive = new SensitiveWord($this->client, self::IM_API_URL, $this->format);

        return $sensitive;
    }

    /**
     * @return \LeeHom\RongCloud\Module\Group Group
     */
    public function Group()
    {
        $group = new Group($this->client, self::IM_API_URL, $this->format);

        return $group;
    }

    /**
     * @return \LeeHom\RongCloud\Module\ChatRoom ChatRoom
     */
    public function ChatRoom()
    {
        $chatroom = new ChatRoom($this->client, self::IM_API_URL, $this->format);

        return $chatroom;
    }

    /**
     * @return \LeeHom\RongCloud\Module\Push Push
     */
    public function Push()
    {
        $push = new Push($this->client, self::IM_API_URL, $this->format);

        return $push;
    }

    /**
     * @return \LeeHom\RongCloud\Module\SMS SMS
     */
    public function SMS()
    {
        $sms = new SMS($this->client, self::SMS_API_URL, $this->format);

        return $sms;
    }
}
