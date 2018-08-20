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

namespace LeeHom\RongCloud\Module;

use GuzzleHttp\Client;
use LeeHom\RongCloud\Exception\RongCloudException;

class User
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
     * User constructor.
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
     * 获取Token方法
     *
     * @param string $userId      用户 Id，最大长度 64 字节.是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。（必传）
     * @param string $name        用户名称，最大长度 128 字节.用来在 Push 推送时显示用户的名称.用户名称，最大长度 128 字节.用来在 Push 推送时显示用户的名称。（必传）
     * @param string $portraitUri 用户头像 URI，最大长度 1024 字节.用来在 Push 推送时显示用户的头像。（必传）
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getToken($userId, $name, $portraitUri)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($name)) {
                throw new RongCloudException('Parameters "name" is required');
            }

            if (empty($portraitUri)) {
                throw new RongCloudException('Parameters "portraitUri" is required');
            }

            $params = [
                'userId'      => $userId,
                'name'        => $name,
                'portraitUri' => $portraitUri
            ];

            $ret = $this->client->request('POST', $this->url . '/user/getToken.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 刷新用户信息方法
     *
     * @param string $userId      用户 Id，最大长度 64 字节.是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。（必传）
     * @param string $name        用户名称，最大长度 128 字节。用来在 Push 推送时，显示用户的名称，刷新用户名称后 5 分钟内生效。（可选，提供即刷新，不提供忽略）
     * @param string $portraitUri 用户头像 URI，最大长度 1024 字节。用来在 Push 推送时显示。（可选，提供即刷新，不提供忽略）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refresh($userId, $name = '', $portraitUri = '')
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            $params = [
                'userId'      => $userId,
                'name'        => $name,
                'portraitUri' => $portraitUri
            ];

            $ret = $this->client->request('POST', $this->url . '/user/refresh.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 检查用户在线状态方法
     *
     * @param string $userId 用户 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkOnline($userId)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            $params = [
                'userId' => $userId
            ];

            $ret = $this->client->request('POST', $this->url . '/user/checkOnline.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 封禁用户方法
     *
     * @param string $userId 用户 Id，支持一次封禁多个用户，最多不超过 20 个。（必传）
     * @param int    $minute 封禁时长，单位为分钟，最大值为43200分钟。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function block($userId, $minute)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($minute)) {
                throw new RongCloudException('Parameters "minute" is required');
            }

            $params = [
                'userId' => $userId,
                'minute' => $minute
            ];

            $ret = $this->client->request('POST', $this->url . '/user/block.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 解除用户封禁方法
     *
     * @param string $userId 用户 Id，支持一次解除多个用户，最多不超过 20 个。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function unBlock($userId)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            $params = [
                'userId' => $userId
            ];

            $ret = $this->client->request('POST', $this->url . '/user/unblock.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 获取被封禁用户方法
     *
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function queryBlock()
    {
        $ret = null;
        try {
            $params = [];

            $ret = $this->client->request('POST', $this->url . '/user/block/query.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 添加用户到黑名单方法
     *
     * @param string $userId      用户 Id。（必传）
     * @param string $blackUserId 被加到黑名单的用户Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addBlacklist($userId, $blackUserId)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($blackUserId)) {
                throw new RongCloudException('Parameters "blackUserId" is required');
            }

            $params = [
                'userId'      => $userId,
                'blackUserId' => $blackUserId
            ];

            $ret = $this->client->request('POST', $this->url . '/user/blacklist/add.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 从黑名单中移除用户方法
     *
     * @param string $userId      用户 Id。（必传）
     * @param string $blackUserId 被移除的用户Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeBlacklist($userId, $blackUserId)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($blackUserId)) {
                throw new RongCloudException('Parameters "blackUserId" is required');
            }

            $params = [
                'userId'      => $userId,
                'blackUserId' => $blackUserId
            ];

            $ret = $this->client->request('POST', $this->url . '/user/blacklist/remove.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 获取某用户的黑名单列表方法
     *
     * @param string $userId 用户 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function queryBlacklist($userId)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            $params = [
                'userId' => $userId
            ];

            $ret = $this->client->request('POST', $this->url . '/user/blacklist/query.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }
}
