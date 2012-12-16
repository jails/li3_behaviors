<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_behaviors\tests\mocks\data\behavior;

class MockFlyBehavior extends \li3_behaviors\data\model\Behavior {

	public static function modelFly($model, $target) {
		return $target . ' reached in 1h54.';
	}

	public function entityFly($entity, $target) {
		return $target . ' reached in 1h24.';
	}
}
