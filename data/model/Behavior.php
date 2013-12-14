<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_behaviors\data\model;

class Behavior extends \lithium\core\Object {

	/**
	 * @see lithium\core\Object::_autoConfig
	 * @var array
	 */
	protected $_autoConfig = ['model'];

	/**
	 * Hold the fully namespaced class name of the model
	 *
	 * @var string
	 */
	protected $_model = null;

	/**
	 * Sets/Gets the configuration for this behavior
	 *
	 * @param array $config The new configuration.
	 * @return array of configurations.
	 */
	public function config($config = null) {
		if ($config) {
			if (!is_array($config)) {
				return isset($this->_config[$config]) ? $this->_config[$config] : null;
			}
			$this->_config = $config + $this->_config;
		}
		return $this->_config;
	}
}
