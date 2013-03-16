<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD(http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_behaviors\tests\mocks\data\model;

use lithium\tests\mocks\data\model\MockDatabase;
use li3_behaviors\data\model\Behaviors;

class MockPost extends \lithium\data\Model {
	use Behaviors;

	protected $_actsAs = [];

	public static $connection = null;

	protected $_meta = ['connection' => false, 'key' => 'id'];

	public static function instances() {
		return array_keys(static::$_instances);
	}

	public static function &connection() {
		if (!static::$connection) {
			$connection = new MockDatabase();
			return $connection;
		}
		return static::$connection;
	}
}

?>