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

class Message
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
     * Message constructor.
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
     * 发送单聊消息方法
     *
     * @param string $fromUserId       发送人用户 Id 。（必传）
     * @param string $toUserId         接收用户Id，提供多个本参数可以实现向多用户发送系统消息，上限为 100 人。（必传）
     * @param string $objectName       消息类型，参考融云消息类型表.消息标志；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:"
     *                                 开头，以避免与融云系统内置消息的
     *                                 ObjectName 重名。（必传）
     * @param string $content          发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @param string $pushContent      定义显示的 Push 内容，如果 objectName 为融云内置消息类型时，则发送后用户一定会收到 Push 信息。 如果为自定义消息，则
     *                                 pushContent 为自定义消息显示的 Push 内容，如果不传则用户不会收到 Push 通知。(可选)
     * @param string $pushData         针对 iOS 平台为 Push 通知时附加到 payload 中，Android 客户端收到推送消息时对应字段名为 pushData。(可选)
     * @param string $count            针对 iOS 平台，Push 时用来控制未读消息显示数，只有在 toUserId 为一个用户 Id 的时候有效。（可选）
     * @param int    $verifyBlacklist  是否过滤发送人黑名单列表，0 表示为不过滤、 1 表示为过滤，默认为 0 不过滤。（可选）
     * @param int    $isPersisted      针对用户当前使用的客户端版本，如果没有对应 objectName 赋值的消息类型时，客户端收到消息后是否进行存储，0 表示为不存储、 1 表示为存储，默认为 1
     *                                 存储消息。(可选)
     * @param int    $isCounted        针对用户当前使用的客户端版本，如果没有对应 objectName 赋值的消息类型时，客户端收到消息后是否进行未读消息计数，0 表示为不计数、 1
     *                                 表示为计数，默认为 1 计数，未读消息数增加 1。(可选)
     * @param int    $isIncludeSender  发送用户自己是否接收消息，0 表示为不接收，1 表示为接收，默认为 0 不接收，只有在 toUserId 为一个用户 Id 的时候有效。（可选）
     * @param int    $contentAvailable 针对 iOS 平台，对 SDK 处于后台暂停状态时为静默推送，是 iOS7 之后推出的一种推送方式。
     *                                 允许应用在收到通知后在后台运行一段代码，且能够马上执行，查看详细。1 表示为开启，0 表示为关闭，默认为 0（可选）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function publishPrivate($fromUserId, $toUserId, $objectName, $content, $pushContent = '', $pushData = '', $count = '', $verifyBlacklist = 0, $isPersisted = 1, $isCounted = 1, $isIncludeSender = 1, $contentAvailable = 0)
    {
        $ret = null;
        try {
            if (empty($fromUserId)) {
                throw new RongCloudException('Parameters "fromUserId" is required');
            }

            if (empty($toUserId)) {
                throw new RongCloudException('Parameters "toUserId" is required');
            }

            if (empty($objectName)) {
                throw new RongCloudException('Parameters "$objectName" is required');
            }

            if (empty($content)) {
                throw new RongCloudException('Parameters "$content" is required');
            }

            $params = [
                'fromUserId'       => $fromUserId,
                'toUserId'         => $toUserId,
                'objectName'       => $objectName,
                'content'          => $content,
                'pushContent'      => $pushContent,
                'pushData'         => $pushData,
                'count'            => $count,
                'verifyBlacklist'  => $verifyBlacklist,
                'isPersisted'      => $isPersisted,
                'isCounted'        => $isCounted,
                'isIncludeSender'  => $isIncludeSender,
                'contentAvailable' => $contentAvailable
            ];

            $ret = $this->client->request('POST', $this->url . '/message/private/publish.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 发送单聊模板消息方法
     *
     * @param string $templateMessage 单聊模版消息。json格式数据
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function publishTemplate($templateMessage)
    {
        $ret = null;
        try {
            if (empty($templateMessage)) {
                throw new RongCloudException('Parameters "templateMessage" is required');
            }

            $params = json_decode($templateMessage, true);

            $ret = $this->client->request('POST', $this->url . '/message/private/publish_template.' . $this->format, ['form_params' => $params, 'headers' => ['Content-Type' => 'application/json']]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 发送系统消息方法
     *
     * @param string $fromUserId       发送人用户 Id 。（必传）
     * @param string $toUserId         接收用户Id，提供多个本参数可以实现向多用户发送系统消息，上限为 100 人。（必传）
     * @param string $objectName       消息类型，参考融云消息类型表.消息标志；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:"
     *                                 开头，以避免与融云系统内置消息的
     *                                 ObjectName 重名。（必传）
     * @param string $content          发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @param string $pushContent      定义显示的 Push 内容，如果 objectName 为融云内置消息类型时，则发送后用户一定会收到 Push 信息。 如果为自定义消息，则
     *                                 pushContent 为自定义消息显示的 Push 内容，如果不传则用户不会收到 Push 通知。(可选)
     * @param string $pushData         针对 iOS 平台为 Push 通知时附加到 payload 中，Android 客户端收到推送消息时对应字段名为 pushData。(可选)
     * @param int    $isPersisted      针对用户当前使用的客户端版本，如果没有对应 objectName 赋值的消息类型时，客户端收到消息后是否进行存储，0 表示为不存储、 1 表示为存储，默认为 1
     *                                 存储消息。(可选)
     * @param int    $isCounted        针对用户当前使用的客户端版本，如果没有对应 objectName 赋值的消息类型时，客户端收到消息后是否进行未读消息计数，0 表示为不计数、 1
     *                                 表示为计数，默认为 1 计数，未读消息数增加 1。(可选)
     * @param int    $contentAvailable 针对 iOS 平台，对 SDK 处于后台暂停状态时为静默推送，是 iOS7 之后推出的一种推送方式。
     *                                 允许应用在收到通知后在后台运行一段代码，且能够马上执行，查看详细。1 表示为开启，0 表示为关闭，默认为 0（可选）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function PublishSystem($fromUserId, $toUserId, $objectName, $content, $pushContent = '', $pushData = '', $isPersisted = 1, $isCounted = 1, $contentAvailable = 0)
    {
        $ret = null;
        try {
            if (empty($fromUserId)) {
                throw new RongCloudException('Parameters "fromUserId" is required');
            }

            if (empty($toUserId)) {
                throw new RongCloudException('Parameters "toUserId" is required');
            }

            if (empty($objectName)) {
                throw new RongCloudException('Parameters "$objectName" is required');
            }

            if (empty($content)) {
                throw new RongCloudException('Parameters "$content" is required');
            }

            $params = [
                'fromUserId'       => $fromUserId,
                'toUserId'         => $toUserId,
                'objectName'       => $objectName,
                'content'          => $content,
                'pushContent'      => $pushContent,
                'pushData'         => $pushData,
                'isPersisted'      => $isPersisted,
                'isCounted'        => $isCounted,
                'contentAvailable' => $contentAvailable
            ];

            $ret = $this->client->request('POST', $this->url . '/message/system/publish.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 发送系统模板消息方法
     *
     * @param string $templateMessage 系统模版消息。json格式数据
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function publishSystemTemplate($templateMessage)
    {
        $ret = null;
        try {
            if (empty($templateMessage)) {
                throw new RongCloudException('Parameters "templateMessage" is required');
            }

            $params = json_decode($templateMessage, true);

            $ret = $this->client->request('POST', $this->url . '/message/system/publish_template.' . $this->format, ['form_params' => $params, 'headers' => ['Content-Type' => 'application/json']]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 发送群组消息方法
     *
     * @param string $fromUserId       发送人用户 Id 。（必传）
     * @param string $toGroupId        接收群 Id，提供多个本参数可以实现向多群发送消息，最多不超过 3 个群组。（必传）
     * @param string $objectName       消息类型，参考融云消息类型表.消息标志；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:" 开头，以避免与融云系统内置消息的
     *                                 ObjectName 重名。（必传）
     * @param string $content          发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @param string $pushContent      定义显示的 Push 内容，如果 objectName 为融云内置消息类型时，则发送后用户一定会收到 Push 信息。 如果为自定义消息，则
     *                                 pushContent 为自定义消息显示的 Push 内容，如果不传则用户不会收到 Push 通知。(可选)
     * @param string $toUserId         群定向消息功能，向群中指定的一个或多个用户发送消息，群中其他用户无法收到该消息，当 toGroupId
     *                                 为一个群组时此参数有效。注：如果开通了“单群聊消息云存储”功能，群定向消息不会存储到云端，向群中部分用户发送消息阅读状态回执时可使用此功能。（可选）
     * @param string $pushData         针对 iOS 平台为 Push 通知时附加到 payload 中，Android 客户端收到推送消息时对应字段名为 pushData。(可选)
     * @param int    $isPersisted      针对用户当前使用的客户端版本，如果没有对应 objectName 赋值的消息类型时，客户端收到消息后是否进行存储，0 表示为不存储、 1 表示为存储，默认为 1
     *                                 存储消息。(可选)
     * @param int    $isCounted        针对用户当前使用的客户端版本，如果没有对应 objectName 赋值的消息类型时，客户端收到消息后是否进行未读消息计数，0 表示为不计数、 1
     *                                 表示为计数，默认为 1 计数，未读消息数增加 1。(可选)
     * @param int    $isIncludeSender  发送用户自己是否接收消息，0 表示为不接收，1 表示为接收，默认为 0 不接收，只有在 toGroupId 为一个群组 Id 的时候有效。（可选）
     * @param int    $isMentioned      是否为 @消息，0 表示为普通消息，1 表示为 @消息，默认为 0。当为 1 时 content 参数中必须携带 mentionedInfo @消息的详细内容。为
     *                                 0 时则不需要携带 mentionedInfo。当指定了 toUserId 时，则 @ 的用户必须为 toUserId 中的用户。（可选）
     * @param int    $contentAvailable 针对 iOS 平台，对 SDK 处于后台暂停状态时为静默推送，是 iOS7 之后推出的一种推送方式。
     *                                 允许应用在收到通知后在后台运行一段代码，且能够马上执行，查看详细。1 表示为开启，0 表示为关闭，默认为 0（可选）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function publishGroup($fromUserId, $toGroupId, $objectName, $content, $toUserId = '', $pushContent = '', $pushData = '', $isPersisted = 1, $isCounted = 1, $isIncludeSender = 1, $isMentioned = 0, $contentAvailable = 0)
    {
        $ret = null;
        try {
            if (empty($fromUserId)) {
                throw new RongCloudException('Parameters "fromUserId" is required');
            }
            if (empty($toGroupId)) {
                throw new RongCloudException('Parameters "toGroupId" is required');
            }
            if (empty($objectName)) {
                throw new RongCloudException('Parameters "$objectName" is required');
            }
            if (empty($content)) {
                throw new RongCloudException('Parameters "$content" is required');
            }

            $params = [
                'fromUserId'      => $fromUserId,
                'toGroupId'       => $toGroupId,
                'objectName'      => $objectName,
                'content'         => $content,
                'pushContent'     => $pushContent,
                'pushData'        => $pushData,
                'isPersisted'     => $isPersisted,
                'isCounted'       => $isCounted,
                'isIncludeSender' => $isIncludeSender
            ];

            $ret = $this->client->request('POST', $this->url . '/message/group/publish.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 发送聊天室消息方法
     *
     * @param string $fromUserId   发送人用户 Id。（必传）
     * @param string $toChatroomId 接收聊天室Id，提供多个本参数可以实现向多个聊天室发送消息，建议最多不超过 10 个聊天室。（必传）
     * @param string $objectName   消息类型，参考融云消息类型表.消息标志；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:" 开头，以避免与融云系统内置消息的
     *                             ObjectName 重名。（必传）
     * @param string $content      发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function publishChatRoom($fromUserId, $toChatroomId, $objectName, $content)
    {
        $ret = null;
        try {
            if (empty($fromUserId)) {
                throw new RongCloudException('Parameters "fromUserId" is required');
            }

            if (empty($toChatroomId)) {
                throw new RongCloudException('Parameters "toChatroomId" is required');
            }

            if (empty($objectName)) {
                throw new RongCloudException('Parameters "$objectName" is required');
            }

            if (empty($content)) {
                throw new RongCloudException('Parameters "$content" is required');
            }

            $params = [
                'fromUserId'   => $fromUserId,
                'toChatroomId' => $toChatroomId,
                'objectName'   => $objectName,
                'content'      => $content
            ];

            $ret = $this->client->request('POST', $this->url . '/message/chatroom/publish.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 发送聊天室广播消息方法
     *
     * @param string $fromUserId 发送人用户 Id。（必传）
     * @param string $objectName 消息类型，参考融云消息类型表.消息标志；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:" 开头，以避免与融云系统内置消息的
     *                           ObjectName 重名。（必传）
     * @param string $content    发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function chatRoomBroadcast($fromUserId, $objectName, $content)
    {
        $ret = null;
        try {
            if (empty($fromUserId)) {
                throw new RongCloudException('Parameters "fromUserId" is required');
            }

            if (empty($objectName)) {
                throw new RongCloudException('Parameters "$objectName" is required');
            }

            if (empty($content)) {
                throw new RongCloudException('Parameters "$content" is required');
            }

            $params = [
                'fromUserId' => $fromUserId,
                'objectName' => $objectName,
                'content'    => $content
            ];

            $ret = $this->client->request('POST', $this->url . '/message/chatroom/broadcast.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 发送广播消息方法
     *
     * @param string $fromUserId       发送人用户 Id。（必传）
     * @param string $objectName       消息类型，参考融云消息类型表.消息标志；可自定义消息类型，长度不超过 32 个字符，您在自定义消息时需要注意，不要以 "RC:"
     *                                 开头，以避免与融云系统内置消息的
     *                                 ObjectName 重名。（必传）
     * @param string $content          发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @param string $pushContent      定义显示的 Push 内容，如果 objectName 为融云内置消息类型时，则发送后用户一定会收到 Push 信息。 如果为自定义消息，则
     *                                 pushContent 为自定义消息显示的 Push 内容，如果不传则用户不会收到 Push 通知。(可选)
     * @param string $pushData         针对 iOS 平台为 Push 通知时附加到 payload 中，Android 客户端收到推送消息时对应字段名为 pushData。(可选)
     * @param string $os               针对操作系统发送 Push，值为 iOS 表示对 iOS 手机用户发送 Push ,为 Android 时表示对 Android 手机用户发送 Push
     *                                 ，如对所有用户发送 Push 信息，则不需要传 os 参数。(可选)
     * @param int    $contentAvailable 针对 iOS 平台，对 SDK 处于后台暂停状态时为静默推送，是 iOS7 之后推出的一种推送方式。
     *                                 允许应用在收到通知后在后台运行一段代码，且能够马上执行，查看详细。1 表示为开启，0 表示为关闭，默认为 0（可选）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function broadcast($fromUserId, $objectName, $content, $pushContent = '', $pushData = '', $os = '', $contentAvailable = 0)
    {
        $ret = null;
        try {
            if (empty($fromUserId)) {
                throw new RongCloudException('Parameters "fromUserId" is required');
            }
            if (empty($objectName)) {
                throw new RongCloudException('Parameters "$objectName" is required');
            }
            if (empty($content)) {
                throw new RongCloudException('Parameters "$content" is required');
            }

            $params = [
                'fromUserId'       => $fromUserId,
                'objectName'       => $objectName,
                'content'          => $content,
                'pushContent'      => $pushContent,
                'pushData'         => $pushData,
                'os'               => $os,
                'contentAvailable' => $contentAvailable
            ];

            $ret = $this->client->request('POST', $this->url . '/message/broadcast.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 消息撤回服务
     *
     * @param string $fromUserId       消息发送人用户 Id。（必传）
     * @param int    $conversationType 会话类型，二人会话是 1 、群组会话是 3 。（必传）
     * @param string $targetId         目标 Id，根据不同的 ConversationType，可能是用户 Id、群组 Id。（必传）
     * @param string $messageUID       消息唯一标识，可通过服务端实时消息路由获取，对应名称为 msgUID。（必传）
     * @param string $sentTime         消息发送时间，可通过服务端实时消息路由获取，对应名称为 msgTimestamp。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function recall($fromUserId, $conversationType, $targetId, $messageUID, $sentTime)
    {
        $ret = null;
        try {
            if (empty($fromUserId)) {
                throw new RongCloudException('Parameters "fromUserId" is required');
            }

            if (empty($conversationType)) {
                throw new RongCloudException('Parameters "conversationType" is required');
            }

            if (empty($targetId)) {
                throw new RongCloudException('Parameters "targetId" is required');
            }

            if (empty($messageUID)) {
                throw new RongCloudException('Parameters "messageUID" is required');
            }

            if (empty($sentTime)) {
                throw new RongCloudException('Parameters "sentTime" is required');
            }

            $params = [
                'fromUserId'       => $fromUserId,
                'conversationType' => $conversationType,
                'targetId'         => $targetId,
                'messageUID'       => $messageUID,
                'sentTime'         => $sentTime
            ];

            $ret = $this->client->request('POST', $this->url . '/message/recall.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 消息历史记录下载地址获取
     *
     * @param string $date 指定北京时间某天某小时，格式为2014010101，表示获取 2014 年 1 月 1 日凌晨 1 点至 2 点的数据。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getHistory($date)
    {
        $ret = null;
        try {
            if (empty($date)) {
                throw new RongCloudException('Parameters "date" is required');
            }

            $params = [
                'date' => $date
            ];

            $ret = $this->client->request('POST', $this->url . '/message/history.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 消息历史记录删除方法
     *
     * @param string $date 指定北京时间某天某小时，格式为2014010101，表示：2014年1月1日凌晨1点。返回成功后，消息记录文件将在随后的 10 分钟内被永久删除。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteHistoryMessage($date)
    {
        $ret = null;
        try {
            if (empty($date)) {
                throw new RongCloudException('Parameters "date" is required');
            }

            $params = [
                'date' => $date
            ];

            $ret = $this->client->request('POST', $this->url . '/message/history/delete.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }
}
