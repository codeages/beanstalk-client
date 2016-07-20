<?php

namespace Codeages\Beanstalk;

use Codeages\Beanstalk\Exception\SocketException;
use Psr\Log\LoggerInterface;

class ClientProxy
{
    protected $client;
    protected $logger;

    public function __construct(Client $client, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function __call($method, $arguments)
    {
        try {
            return call_user_func_array([$this->client, $method], $arguments);
        } catch (SocketException $e) {
            if ($this->logger) {
                $message = sprintf('When call %s(%s), beanstalk reconnect(%s).', $method, substr(json_encode($arguments), 0, 100), json_encode($this->client->getConfig()));
                $this->logger->info($message);
            }
            $this->client->reconnect();

            return call_user_func_array([$this->client, $method], $arguments);
        }
    }
}
