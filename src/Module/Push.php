<?php
// +----------------------------------------------------------------------
// | 融云服务端SDK-PHP
// +----------------------------------------------------------------------
// | Copyright (c) 2017~2018 LeeHom1988 All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( https://github.com/leehom1988/rongcloud-sdk-php/blob/master/LICENSE )
// +----------------------------------------------------------------------
// | Author: LeeHom1988 <lh411937409@gmail.com>
// +----------------------------------------------------------------------

namespace LeeHom\RongCloud\Module;

use GuzzleHttp\Client;
use LeeHom\RongCloud\Exception\RongCloudException;

class Push
{

    /**
     * 融云网络请求服务客户端
     *
     * @var Client Client
     */
    private $client;

    /**
     * 请求地址
     *
     * @var string $url
     */
    private $url;

    /**
     * 返回数据格式
     *
     * @var string $format
     */
    private $format;

    /**
     * Push constructor.
     *
     * @param Client $client
     * @param string $url
     * @param string $format
     */
    public function __construct($client, $url, $format)
    {
        $this->client = $client;
        $this->format = $format;
        $this->url    = $url;
    }

    /**
     * 添加Push标签方法
     *
     * @param string $userId 用户 Id。（必传）
     * @param array  $tags   用户标签，一个用户最多添加 20 个标签，每个 tags 最大不能超过 40 个字节，标签中不能包含特殊字符。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setUserPushTag($userId, $tags)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }
            if (empty($tags)) {
                throw new RongCloudException('Parameters "tags" is required');
            }

            $params = [
                'userId' => $userId,
                'tags'   => $tags
            ];

            $ret = $this->client->request('POST', $this->url . '/user/tag/set.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 批量添加标签方法
     *
     * @param array $userId 用户 Id。（必传）
     * @param array $tags   用户标签，一个用户最多添加 20 个标签，每个 tags 最大不能超过 40 个字节，标签中不能包含特殊字符。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function batchSetUserPushTag($userId, $tags)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }
            if (empty($tags)) {
                throw new RongCloudException('Parameters "tags" is required');
            }

            $params = [
                'userId' => $userId,
                'tags'   => $tags
            ];

            $ret = $this->client->request('POST', $this->url . '/user/tag/batch/set.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 广播消息方法
     *
     * @param string $pushMessage json字符串数据
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function broadcastPush($pushMessage)
    {
        $ret = null;
        try {
            if (empty($pushMessage)) {
                throw new RongCloudException('Parameters "pushMessage" is required');
            }

            $params = json_decode($pushMessage, true);

            $ret = $this->client->request('POST', $this->url . '/push.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }
}
