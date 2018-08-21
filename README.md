# RongCloud PHP SDK
[![Latest Stable Version](https://poser.pugx.org/leehom1988/rongcloud-sdk-php/v/stable)](https://packagist.org/packages/leehom1988/rongcloud-sdk-php)
[![Total Downloads](https://poser.pugx.org/leehom1988/rongcloud-sdk-php/downloads)](https://packagist.org/packages/leehom1988/rongcloud-sdk-php)
[![Latest Unstable Version](https://poser.pugx.org/leehom1988/rongcloud-sdk-php/v/unstable)](https://packagist.org/packages/leehom1988/rongcloud-sdk-php)
[![License](https://poser.pugx.org/leehom1988/rongcloud-sdk-php/license)](https://packagist.org/packages/leehom1988/rongcloud-sdk-php) [![Join the chat at https://gitter.im/rongcloud-sdk-php/Lobby](https://badges.gitter.im/rongcloud-sdk-php/Lobby.svg)](https://gitter.im/rongcloud-sdk-php/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

融云服务端SDK，使用PHP实现。

本版本是在官方SDK版本基础上开发而成，使用Guzzle替代了cURL请求实现，集成了composer库管理。

## 安装

推荐使用Composer安装该SDK。关于Composer的使用，请查看该链接[Composer](https://getcomposer.org/)。

```bash
$ composer require leehom1988/rongcloud-sdk-php
```

运行上面命令，将会自动安装该SDK需要的所有依赖，注意：该SDK需要在PHP5.6.0或更新的版本上运行。

## 使用

```php
<?php
require 'vendor/autoload.php';

use LeeHom\RongCloud\RongClient;
use LeeHom\RongCloud\Exception\RongCloudException;
use GuzzleHttp\Exception\GuzzleException;

$client = new RongClient('xxxxxxxxxx', 'xxxxxxxxxx');
try {
    $r = $client->User()->getToken('user_id', 'test name', 'http://www.rongcloud.cn/images/logo.png');
    echo $r;
} catch (RongCloudException $e) {
    echo $e->getMessage();
} catch (GuzzleException $e) {
    echo $e->getMessage();
}
```

## About
If you have any question,Please be easy to contact me:
- Name: LeeHom
- Email: lh411937409@gmail.com

Hope it can help You,Just Enjoy It! 😁😁😁😁

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.