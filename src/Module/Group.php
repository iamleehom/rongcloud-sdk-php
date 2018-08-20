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

class Group
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
     * Group constructor.
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
     * 同步用户所属群组方法
     *
     * @param string $userId    被同步群信息的用户 Id。（必传）
     * @param string $groupInfo 该用户的群信息，如群 Id 已经存在，则不会刷新对应群组名称，如果想刷新群组名称请调用刷新群组信息方法。
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sync($userId, $groupInfo)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }
            if (empty($groupInfo)) {
                throw new RongCloudException('Parameters "groupInfo" is required');
            }

            $params           = [];
            $params['userId'] = $userId;

            foreach ($groupInfo as $key => $value) {
                $params['group[' . $key . ']'] = $value;
            }

            $ret = $this->client->request('POST', $this->url . '/group/sync.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 创建群组方法
     *
     * @param string $userId    要加入群的用户 Id。（必传）
     * @param string $groupId   创建群组 Id。（必传）
     * @param string $groupName 群组 Id 对应的名称。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($userId, $groupId, $groupName)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            if (empty($groupName)) {
                throw new RongCloudException('Parameters "groupName" is required');
            }

            $params = [
                'userId'    => $userId,
                'groupId'   => $groupId,
                'groupName' => $groupName
            ];

            $ret = $this->client->request('POST', $this->url . '/group/create.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 加入群组方法
     *
     * @param string $userId    要加入群的用户 Id，可提交多个，最多不超过 1000 个。（必传）
     * @param string $groupId   要加入的群 Id。（必传）
     * @param string $groupName 要加入的群 Id 对应的名称。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function join($userId, $groupId, $groupName)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            if (empty($groupName)) {
                throw new RongCloudException('Parameters "groupName" is required');
            }

            $params = [
                'userId'    => $userId,
                'groupId'   => $groupId,
                'groupName' => $groupName
            ];

            $ret = $this->client->request('POST', $this->url . '/group/join.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 退出群组方法
     *
     * @param string $userId  要退出群的用户 Id.（必传）
     * @param string $groupId 要退出的群 Id.（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function quit($userId, $groupId)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            $params = [
                'userId'  => $userId,
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/quit.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 解散群组方法
     *
     * @param string $userId  操作解散群的用户 Id。（必传）
     * @param string $groupId 要解散的群 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function dismiss($userId, $groupId)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            $params = [
                'userId'  => $userId,
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/dismiss.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 刷新群组信息方法
     *
     * @param string $groupId   群组 Id。（必传）
     * @param string $groupName 群名称。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refresh($groupId, $groupName)
    {
        $ret = null;
        try {
            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            if (empty($groupName)) {
                throw new RongCloudException('Parameters "groupName" is required');
            }

            $params = [
                'groupId'   => $groupId,
                'groupName' => $groupName
            ];

            $ret = $this->client->request('POST', $this->url . '/group/refresh.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询群成员方法
     *
     * @param string $groupId 群组Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function queryUser($groupId)
    {
        $ret = null;
        try {
            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            $params = [
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/user/query.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 添加禁言群成员方法
     *
     * @param string $userId  用户 Id。（必传）
     * @param string $groupId 群组 Id。（必传）
     * @param string $minute  禁言时长，以分钟为单位，最大值为43200分钟。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addGagUser($userId, $groupId, $minute)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            if (empty($minute)) {
                throw new RongCloudException('Parameters "minute" is required');
            }

            $params = [
                'userId'  => $userId,
                'groupId' => $groupId,
                'minute'  => $minute
            ];

            $ret = $this->client->request('POST', $this->url . '/group/user/gag/add.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 移除禁言群成员方法
     *
     * @param string $userId  用户Id。支持同时移除多个群成员（必传）
     * @param string $groupId 群组Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function rollBackGagUser($userId, $groupId)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            $params = [
                'userId'  => $userId,
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/user/gag/rollback.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询被禁言群成员方法
     *
     * @param string $groupId 群组Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listGagUser($groupId)
    {
        $ret = null;
        try {
            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            $params = [
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/user/gag/list.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 添加禁言群方法
     *
     * @param string $groupId 群组 Id，支持一次设置多个，最多不超过 20 个。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addBanGroup($groupId)
    {
        $ret = null;
        try {
            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            $params = [
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/ban/add.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 移除禁言群方法
     *
     * @param string $groupId 群组 Id，支持一次设置多个，最多不超过 20 个。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function rollBackBanGroup($groupId)
    {
        $ret = null;
        try {
            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            $params = [
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/ban/rollback.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询被禁言群方法
     *
     * @param string $groupId 群组 Id，不传此参数，表示查询所有设置禁言的群组列表；传此参数时，表示查询传入的群组 Id 是否被设置为群组禁言，支持一次查询多个，最多不超过 20 个。（非必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listBanGroup($groupId = '')
    {
        $ret = null;
        try {
            $params = [
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/ban/query.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 添加禁言白名单用户方法
     *
     * @param string $userId  用户 Id，支持一次添加多个用户，最多不超过 20 个。（必传
     * @param string $groupId 群组 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addBanGroupUserWhiteList($userId, $groupId)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            $params = [
                'userId'  => $userId,
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/user/ban/whitelist/add.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 移除禁言白名单用户方法
     *
     * @param string $userId  用户 Id，支持一次添加多个用户，最多不超过 20 个。（必传
     * @param string $groupId 群组 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function rollBackBanGroupUserWhiteList($userId, $groupId)
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            $params = [
                'userId'  => $userId,
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/user/ban/whitelist/rollback.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询禁言白名单用户列表方法
     *
     * @param string $groupId 群组 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listBanGroupUserWhiteList($groupId)
    {
        $ret = null;
        try {
            if (empty($groupId)) {
                throw new RongCloudException('Parameters "groupId" is required');
            }

            $params = [
                'groupId' => $groupId
            ];

            $ret = $this->client->request('POST', $this->url . '/group/user/ban/whitelist/query.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }
}
