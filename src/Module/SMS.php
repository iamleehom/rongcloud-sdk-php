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

class SMS
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
     * SMS constructor.
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
     * 获取图片验证码方法
     *
     * @param  appKey:应用Id
     * @return $json
     **/
    /**
     * 获取图片验证码方法
     *
     * @param string $appKey 应用app key
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getImageCode($appKey)
    {
        $ret = null;
        try {
            if (empty($appKey)) {
                throw new RongCloudException('Parameters "appKey" is required');
            }

            $params = [
                'appKey' => $appKey
            ];

            $ret = $this->client->request('GET', $this->url . '/getImgCode.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 发送短信验证码方法
     *
     * @param string $mobile     接收短信验证码的目标手机号，每分钟同一手机号只能发送一次短信验证码。（必传）
     * @param string $templateId 短信模板 Id，在“开发者后台->短信服务->服务设置->短信模版”中获取。（必传）
     * @param string $region     手机号码所属国家区号，目前只支持中国区号 86（必传）
     * @param string $verifyId   图片验证标识 Id ，开启图片验证功能后此参数必传，否则可以不传。在获取图片验证码方法返回值中获取。
     * @param string $verifyCode 图片验证码，开启图片验证功能后此参数必传，否则可以不传。
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendCode($mobile, $templateId, $region, $verifyId = '', $verifyCode = '')
    {
        $ret = null;
        try {
            if (empty($mobile)) {
                throw new RongCloudException('Parameters "mobile" is required');
            }
            if (empty($templateId)) {
                throw new RongCloudException('Parameters "templateId" is required');
            }
            if (empty($region)) {
                throw new RongCloudException('Parameters "region" is required');
            }

            $params = [
                'mobile'     => $mobile,
                'templateId' => $templateId,
                'region'     => $region,
                'verifyId'   => $verifyId,
                'verifyCode' => $verifyCode
            ];

            $ret = $this->client->request('POST', $this->url . '/sendCode.' . $this->format, ['form_params' => $params]);

            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 验证码验证方法
     *
     * @param string $sessionId 短信验证码唯一标识，在发送短信验证码方法，返回值中获取。（必传）
     * @param string $code      短信验证码内容。（必传）
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifyCode($sessionId, $code)
    {
        $ret = null;
        try {
            if (empty($sessionId)) {
                throw new RongCloudException('Parameters "sessionId" is required');
            }
            if (empty($code)) {
                throw new RongCloudException('Parameters "code" is required');
            }

            $params = [
                'sessionId' => $sessionId,
                'code'      => $code
            ];

            $ret = $this->client->request('POST', $this->url . '/verifyCode.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }

    /**
     * 发送通知类短信方法
     *
     * @param string $mobile     接收通知短信的目标手机号。（必传）
     * @param string $templateId 短信模板 Id，在“开发者后台->短信服务->服务设置->短信模版”中获取。（必传）
     * @param string $region     手机号码所属国家区号，目前只支持中国区号 86（必传）
     * @param string $p1         短信模板中，自定义变量值，如果在通知短信模板中定义了 {p1} 则在发送通知短信时必须传入此参数，替换模板中的 {p1}，否则此参数可以不传。
     * @param string $p2         短信模板中，自定义变量值，如果在通知短信模板中定义了 {p2} 则在发送通知短信时必须传入此参数，替换模板中的 {p2}，否则此参数可以不传。
     * @param string $p3         短信模板中，自定义变量值，如果在通知短信模板中定义了 {p3} 则在发送通知短信时必须传入此参数，替换模板中的 {p3}，否则此参数可以不传。
     * @return mixed|null|\Psr\Http\Message\ResponseInterface
     * @throws RongCloudException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendNotify($mobile, $templateId, $region, $p1 = '', $p2 = '', $p3 = '')
    {
        $ret = null;
        try {
            if (empty($mobile)) {
                throw new RongCloudException('Parameters "mobile" is required');
            }
            if (empty($templateId)) {
                throw new RongCloudException('Parameters "templateId" is required');
            }
            if (empty($region)) {
                throw new RongCloudException('Parameters "region" is required');
            }

            $params = [
                'mobile'     => $mobile,
                'templateId' => $templateId,
                'region'     => $region,
                'p1'         => $p1,
                'p2'         => $p2,
                'p3'         => $p3
            ];

            $ret = $this->client->request('POST', $this->url . '/sendNotify.' . $this->format, ['form_params' => $params]);
            if (empty($ret) || is_null($ret)) {
                throw new RongCloudException('Bad request');
            }
        } catch (\Exception $e) {
            throw new RongCloudException($e->getMessage());
        }

        return $ret->getBody()->getContents();
    }
}
