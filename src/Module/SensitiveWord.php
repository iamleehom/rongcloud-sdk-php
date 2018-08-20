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

class SensitiveWord
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
     * SensitiveWord constructor.
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
     * 添加敏感词方法
     *
     * @param string $word        敏感词，最长不超过 32 个字符，格式为汉字、数字、字母。（必传）
     * @param string $replaceWord 需要替换的敏感词，最长不超过 32
     *                            个字符，（非必传）。如未设置替换的敏感词，当消息中含有敏感词时，消息将被屏蔽，用户不会收到消息。如设置了替换敏感词，当消息中含有敏感词时，将被替换为指定的字符进行发送。敏感词替换目前只支持单聊、群聊、聊天室会话。
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add($word, $replaceWord = '')
    {
        $ret = null;
        try {
            if (empty($word)) {
                throw new RongCloudException('Parameters "word" is required');
            }

            $params = [
                'word'        => $word,
                'replaceWord' => $replaceWord
            ];

            $ret = $this->client->request('POST', $this->url . '/sensitiveword/add.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 查询敏感词列表方法
     *
     * @param string $type 查询敏感词的类型，0 为查询替换敏感词，1 为查询屏蔽敏感词，2 为查询全部敏感词。默认为 1。（非必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList($type = '1')
    {
        $ret = null;
        try {
            $params = [
                'type' => $type
            ];

            $ret = $this->client->request('POST', $this->url . '/sensitiveword/list.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 移除敏感词方法
     *
     * @param string $word 敏感词，最长不超过 32 个字符。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($word)
    {
        $ret = null;
        try {
            if (empty($word)) {
                throw new RongCloudException('Parameters "word" is required');
            }

            $params = [
                'word' => $word
            ];

            $ret = $this->client->request('POST', $this->url . '/sensitiveword/delete.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 批量移除敏感词方法
     *
     * @param array $words 敏感词数组，一次最多移除 50 个敏感词。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function batchDelete($words)
    {
        $ret = null;
        try {
            if (empty($words)) {
                throw new RongCloudException('Parameters "words" is required');
            }

            $params = [
                'words' => $words
            ];

            $ret = $this->client->request('POST', $this->url . '/sensitiveword/batch/delete.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }
}
