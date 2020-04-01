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

class ChatRoom
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
     * ChatRoom constructor.
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
     * 创建聊天室方法
     *
     * @param array $chatRoomInfo id:要创建的聊天室的id；name:要创建的聊天室的name。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($chatRoomInfo)
    {
        $ret = null;
        try {
            if (empty($chatRoomInfo)) {
                throw new RongCloudException('Parameters "chatRoomInfo" is required');
            }

            $params = [];

            foreach ($chatRoomInfo as $key => $value) {
                $params['chatroom[' . $key . ']'] = $value;
            }

            $ret = $this->client->request('POST', $this->url . '/chatroom/create.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 销毁聊天室方法
     *
     * @param string $chatroomId 要销毁的聊天室 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($chatroomId)
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/destroy.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询聊天室信息方法
     *
     * @param string $chatroomId 要查询的聊天室id（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function query($chatroomId)
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatRoomId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/query.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询聊天室内用户方法
     *
     * @param string $chatroomId 要查询的聊天室 ID。（必传）
     * @param string $count      要获取的聊天室成员数，上限为 500 ，超过 500 时最多返回 500 个成员。（必传）
     * @param string $order      加入聊天室的先后顺序， 1 为加入时间正序， 2 为加入时间倒序。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function queryUser($chatroomId, $count, $order)
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            if (empty($count)) {
                throw new RongCloudException('Parameters "count" is required');
            }

            if (empty($order)) {
                throw new RongCloudException('Parameters "order" is required');
            }

            $params = [
                'chatroomId' => $chatroomId,
                'count'      => $count,
                'order'      => $order
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/query.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询用户是否在聊天室方法
     *
     * @param string $chatroomId 要查询的聊天室 ID。（必传）
     * @param string $userId     要查询的用户 ID（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function userExist($chatroomId, $userId)
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId,
                'userId'     => $userId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/exist.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 批量查询用户是否在聊天室方法
     *
     * @param string $chatroomId 要查询的聊天室 ID。（必传）
     * @param string $userId     要查询的用户 ID（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function usersExist($chatroomId, $userId)
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId,
                'userId'     => $userId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/users/exist.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 加入聊天室方法
     *
     * @param string $userId     要加入聊天室的用户 Id，可提交多个，最多不超过 50 个。（必传）
     * @param string $chatroomId 要加入的聊天室 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function join($userId = '', $chatroomId = '')
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            $params = [
                'userId'     => $userId,
                'chatroomId' => $chatroomId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/join.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 聊天室消息停止分发方法
     *
     * @param string $chatroomId 聊天室 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stopDistributionMessage($chatroomId = '')
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/message/stopDistribution.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 聊天室消息恢复分发方法
     *
     * @param string $chatroomId 聊天室 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function resumeDistributionMessage($chatroomId = '')
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/message/resumeDistribution.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 添加禁言聊天室成员方法
     *
     * @param string $userId     用户 Id。（必传）
     * @param string $chatroomId 聊天室 Id。（必传）
     * @param string $minute     禁言时长，以分钟为单位，最大值为43200分钟。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addGagUser($userId = '', $chatroomId = '', $minute = '')
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }
            if (empty($minute)) {
                throw new RongCloudException('Parameters "minute" is required');
            }

            $params = [
                'userId'     => $userId,
                'chatroomId' => $chatroomId,
                'minute'     => $minute
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/gag/add.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询被禁言聊天室成员方法
     *
     * @param string $chatroomId 聊天室 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function ListGagUser($chatroomId = '')
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/gag/list.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 移除禁言聊天室成员方法
     *
     * @param string $userId     用户 Id。（必传）
     * @param string $chatroomId 聊天室Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function rollbackGagUser($userId = '', $chatroomId = '')
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            $params = [
                'userId'     => $userId,
                'chatroomId' => $chatroomId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/gag/rollback.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 添加封禁聊天室成员方法
     *
     * @param string $userId     用户 Id。（必传）
     * @param string $chatroomId 聊天室 Id。（必传）
     * @param string $minute     封禁时长，以分钟为单位，最大值为43200分钟。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addBlockUser($userId = '', $chatroomId = '', $minute = '')
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }
            if (empty($minute)) {
                throw new RongCloudException('Parameters "minute" is required');
            }

            $params = [
                'userId'     => $userId,
                'chatroomId' => $chatroomId,
                'minute'     => $minute
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/block/add.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询被封禁聊天室成员方法
     *
     * @param string $chatroomId 聊天室 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getListBlockUser($chatroomId = '')
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/block/list.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 移除封禁聊天室成员方法
     *
     * @param string $userId     用户 Id。（必传）
     * @param string $chatroomId 聊天室 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function rollbackBlockUser($userId = '', $chatroomId = '')
    {
        $ret = null;
        try {
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }
            $params = [
                'userId'     => $userId,
                'chatroomId' => $chatroomId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/block/rollback.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 添加聊天室消息优先级方法
     *
     * @param string $objectName 低优先级的消息类型，每次最多提交 5 个，设置的消息类型最多不超过 20 个。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addPriority($objectName = '')
    {
        $ret = null;
        try {
            if (empty($objectName)) {
                throw new RongCloudException('Parameters "objectName" is required');
            }

            $params = [
                'objectName' => $objectName
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/message/priority/add.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 添加聊天室白名单成员方法
     *
     * @param string $chatroomId 聊天室中用户 Id，可提交多个，聊天室中白名单用户最多不超过 5 个。（必传）
     * @param string $userId     聊天室 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addWhiteListUser($chatroomId = '', $userId = '')
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId,
                'userId'     => $userId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/whitelist/add.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 移除聊天室白名单成员方法
     *
     * @param string $chatroomId 聊天室中用户 Id，可提交多个，聊天室中白名单用户最多不超过 5 个。（必传）
     * @param string $userId     聊天室 Id。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeWhiteListUser($chatroomId = '', $userId = '')
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }
            if (empty($userId)) {
                throw new RongCloudException('Parameters "userId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId,
                'userId'     => $userId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/whitelist/remove.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询聊天室白名单成员方法
     *
     * @param string $chatroomId 聊天室中用户 Id，可提交多个，聊天室中白名单用户最多不超过 5 个。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function queryWhiteListUser($chatroomId = '')
    {
        $ret = null;
        try {
            if (empty($chatroomId)) {
                throw new RongCloudException('Parameters "chatroomId" is required');
            }

            $params = [
                'chatroomId' => $chatroomId
            ];

            $ret = $this->client->request('POST', $this->url . '/chatroom/user/whitelist/query.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }
}
