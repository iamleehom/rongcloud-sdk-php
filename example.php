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

require 'vendor/autoload.php';

use LeeHom\RongCloud\RongClient;
use LeeHom\RongCloud\Exception\RongCloudException;
use GuzzleHttp\Exception\GuzzleException;

$client = new RongClient('xxxxxxxxxx', 'xxxxxxxxxx');
try {
    $r = $client->Message()->publishPrivate('123', '456', 'RC:TxtMsg', '{"content":"Hello 456"}');
    echo $r;
} catch (RongCloudException $e) {
    echo $e->getMessage();
} catch (GuzzleException $e) {
    echo $e->getMessage();
}
