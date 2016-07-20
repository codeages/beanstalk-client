<?php

namespace Codeages\Beanstalk\Test;

use Codeages\Beanstalk\BeanstalkClient;
use Codeages\Beanstalk\Helper;

class BeanstalkClientTest extends \PHPUnit_Framework_TestCase
{
    const TUBE_NAME = 'default';

    public function setUp()
    {
        $client = new BeanstalkClient(['persistent' => true]);
        $client->connect();

        $helper = new Helper($client);
        $helper->emptyTube(self::TUBE_NAME);

        $client->disconnect();
    }

    public function testPut()
    {
        // $client = new Client(['persistent' => false]);
        // $client->connect();
        // $client->useTube(self::TUBE_NAME);

        // $puted = $client->put(1000, 0, 600, 'hello, phpunit.');
        // $this->assertGreaterThan(0, $puted);

        // $client->disconnect();
    }

    // public function testReserve()
    // {
    //     $client = new Client(['persistent' => false]);
    //     $client->connect();
    //     $client->useTube(self::TUBE_NAME);

    //     $jobId = $client->put(1000, 0, 600, 'hello, phpunit..');

    //     $client->watch(self::TUBE_NAME);
    //     $job = $client->reserve();

    //     $this->assertEquals($jobId, $job['id']);

    //     $client->disconnect();
    // }

    // public function testReconnect()
    // {
    //     return ;
    //     $client = new Client(['persistent' => true]);
    //     $client->connect();
    //     $client->useTube(self::TUBE_NAME);

    //     // sleep(10);

    //     $tmpClient = new Client(['persistent' => true]);
    //     $tmpClient->connect();
    //     $tmpClient->disconnect();

    //     $jobId = $client->put(1000, 0, 600, 'hello, phpunit..');

    //     var_dump($jobId);

    // }
}