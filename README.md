# README

在[davidpersson/beanstalk](https://github.com/davidpersson/beanstalk)的基础上, 对原Client类进行了以下改造：

  * 初始化时，加入了`socket_timeout`参数，设置socket执行的超时时间；
  * 加入了Exception机制，以区分命令执行失败的情况；
  * 加入了reconnect方法，当socket异常关闭时，可调用此方法重新打开socket，并自动监听相关tube。

新增：

  * ClientProxy类，此类实现了当socket被异常关闭时，会自动重连。
  * Help类，对队列的清空提供了辅助函数。

## Installation

```
composer require codeages/beanstalk-client
```

## Usage

```php
use Codeages\Beanstalk\Client;

$client = new Client([/* options */]);
$connected = $client->connect();
```

代理类的使用：

```php
use Codeages\Beanstalk\Client;
use Codeages\Beanstalk\ClientProxy;

$client = new Client([/* options */]);
$client = new ClientProxy($client);
$client->connect();
$client->put(.......);
```

## License

MIT.