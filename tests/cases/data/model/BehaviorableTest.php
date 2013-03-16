<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_behaviors\tests\cases\data\model;

use li3_behaviors\tests\mocks\data\model\MockPost;

class BehaviorableTest extends \lithium\test\Unit {

	public function tearDown() {
		MockPost::reset();
	}

	public function testActsAs() {
		$model = 'li3_behaviors\tests\mocks\data\behavior\MockFlyBehavior';
		MockPost::actsAs($model, ['param1' => 'value1']);

		$expected = [
			'param1' => 'value1',
			'model' => 'li3_behaviors\tests\mocks\data\model\MockPost',
			'init' => true,
		];
		$this->assertEqual($expected, MockPost::actsAs($model, true));
		$this->assertEqual('value1', MockPost::actsAs($model, true, 'param1'));

		MockPost::actsAs($model, ['param2' => 'value2']);
		$expected['param2'] = 'value2';
		$this->assertEqual($expected, MockPost::actsAs($model, true));
	}

	public function testCallStatic() {
		$model = 'li3_behaviors\tests\mocks\data\behavior\MockFlyBehavior';
		MockPost::actsAs($model, ['param1' => 'value1']);
		$this->assertEqual('New York reached in 1h54.', MockPost::modelFly('New York'));
	}

	public function testCall() {
		$model = 'li3_behaviors\tests\mocks\data\behavior\MockFlyBehavior';
		MockPost::actsAs($model, ['param1' => 'value1']);
		$entity = MockPost::create();
		$this->assertEqual('Las Vegas reached in 1h24.', $entity->entityFly('Las Vegas'));
	}

	public function testUnexistingBehavior() {
		$model = 'li3_behaviors\tests\mocks\data\behavior\MockFlyBehavior';
		$this->expectException("/Unexisting Behavior/");
		MockPost::actsAs($model, true);
	}
}