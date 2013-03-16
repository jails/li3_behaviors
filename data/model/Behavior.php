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
	 * Holding the configuration array of the behavior
	 *
	 * @var array
	 */
	protected $_config = [];
	/**
	 * @see lithium\core\Object::_autoConfig
	 * @var array
	 */
	protected $_autoConfig = ['model', 'config'];
	/**
	 * Hold the fully namespaced class name of the model
	 *
	 * @var string
	 */
	protected $_model = null;

	/**
	 * Bind
	 *
	 * Applies Behaviour to the Model and configures its use
	 *
	 * @param \lithium\data\Model $self The Model using this behaviour
	 */
	public function __construct($config = []) {
		parent::__construct($config);
	}

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
