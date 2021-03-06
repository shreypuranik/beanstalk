<?php
/**
 * beanstalk: A minimalistic PHP beanstalk client.
 *
 * Copyright (c) 2009-2015 David Persson
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 */

namespace Beanstalk;

use Beanstalk\Client;

/**
 * Class ConnectTest
 * @package Beanstalk
 */
class ConnectTest extends \PHPUnit_Framework_TestCase {

	public $subject;

    /**
     * Define environments,
     * and setup Client object
     */
    protected function setUp() {
		$host = getenv('TEST_BEANSTALKD_HOST');
		$port = getenv('TEST_BEANSTALKD_PORT');

		if (!$host || !$port) {
			$message = 'TEST_BEANSTALKD_HOST and/or TEST_BEANSTALKD_PORT env variables not defined.';
			$this->markTestSkipped($message);
		}
		$this->subject = new Client(compact('host', 'port'));

		if (!$this->subject->connect()) {
			$message  = "Need a running beanstalkd server at {$host}:{$port}.";
			$this->markTestSkipped($message);
		}
	}

    /**
     * Run tests against methods and variables
     * from the Client object
     */
    public function testConnection() {
		$this->subject->disconnect();

		$result = $this->subject->connect();
		$this->assertTrue($result);

		$result = $this->subject->connected;
		$this->assertTrue($result);

		$result = $this->subject->disconnect();
		$this->assertTrue($result);

		$result = $this->subject->connected;
		$this->assertFalse($result);
	}
}

?>