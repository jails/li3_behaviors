<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_behaviors\tests\cases\data\model;

use li3_behaviors\data\model\Behavior;

class BehaviorTest extends \lithium\test\Unit {

	public function testConfig() {
		$behavior = new Behavior(array('config' => array('test1' => 'value1')));
		$this->assertEqual('value1', $behavior->config('test1'));

		$behavior->config(array('test2' => 'value2'));
		$this->assertEqual('value1', $behavior->config('test1'));
		$this->assertEqual('value2', $behavior->config('test2'));

		$behavior->config(array('test1' => 'value1 changed', 'test2' => 'value2'));
		$this->assertEqual('value1 changed', $behavior->config('test1'));
		$this->assertEqual('value2', $behavior->config('test2'));
	}
}
?>