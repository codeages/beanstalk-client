# BeanstalkClient

主体代码来自https://github.com/davidpersson/beanstalk, 加入了异常、断线重连机制。

```
$client = new Client();
$connected = $client->connect();
```