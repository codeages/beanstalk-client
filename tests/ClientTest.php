<?php

namespace EduSoho\Beanstalk\Test;

use EduSoho\Beanstalk\Client;
use EduSoho\Beanstalk\Helper;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    const TUBE_NAME = 'phpunit';

    public function __construct()
    {
        $client = new Client();
        $client->connect();
        $client->useTube(self::TUBE_NAME);

        $this->client = $client;
        $this->helper = new Helper($client);
    }

    public function setUp()
    {
        $this->helper->emptyTube(self::TUBE_NAME);
    }

    public function testPut()
    {
        $puted = $this->client->put(1000, 0, 600, 'hello, phpunit.');
        $this->assertGreaterThan(0, $puted);
    }

    public function testReserve()
    {
        $jobId = $this->client->put(1000, 0, 600, 'hello, phpunit..');

        $this->client->watch(self::TUBE_NAME);
        $job = $this->client->reserve();

        $this->assertEquals($jobId, $job['id']);
    }
}