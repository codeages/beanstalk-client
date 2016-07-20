<?php

namespace Codeages\Beanstalk\Test;

use Codeages\Beanstalk\Client;
use Codeages\Beanstalk\Helper;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    const TUBE_NAME = 'phpunit';

    public function setUp()
    {
        $client = new Client(['persistent' => false]);
        $client->connect();

        $helper = new Helper($client);
        $helper->emptyTube(self::TUBE_NAME);

        $client->disconnect();
    }

    public function testPut()
    {
        $client = new Client(['persistent' => false]);
        $client->connect();
        $client->useTube(self::TUBE_NAME);

        $puted = $client->put(1000, 0, 600, 'hello, phpunit.');
        $this->assertGreaterThan(0, $puted);

        $client->disconnect();
    }

    public function testReserve()
    {
        $client = new Client(['persistent' => false]);
        $client->connect();
        $client->useTube(self::TUBE_NAME);

        $jobId = $client->put(1000, 0, 600, 'hello, phpunit..');

        $client->watch(self::TUBE_NAME);
        $job = $client->reserve();

        $this->assertEquals($jobId, $job['id']);

        $client->disconnect();
    }
}