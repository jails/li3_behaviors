<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_behaviors\data\model;

use lithium\core\Libraries;
use RuntimeException;

class Behaviorable extends \lithium\data\Model {

	/**
	 * List of behaviors to load
	 *
	 * @var array
	 */
	protected $_actsAs = array();
	/**
	 * Store all loaded behaviors
	 *
	 * @see Model::_actsAs
	 * @var array
	 */
	protected $_behaviors = array();

	/**
	 * Boolean indicates if the `Model::_init()` has been launched at the initialization step.
	 */
	protected $_inited = false;

	/**
	 * Allow the exectution of a kind of `_init()` for the model instance once.
	 *
	 * @param string $class The fully-namespaced class name to initialize.
	 */
	protected static function _initialize($class) {
		$self = parent::_initialize($class);
		if (!$self->_inited) {
			$self->_inited = true;
			$self->_init();
		}
		return $self;
	}

	/**
	 * Initializer function called just after the model instanciation.
	 *
	 * Example to disable the `_init()` call use the following before any access to the model:
	 * {{{
	 * Posts::config(array('init' => false));
	 * }}}
	 */
	protected function _init() {
		$self = static::_object();
		foreach ($self->_actsAs as $name => $config) {
			if (is_string($config)) {
				$name = $config;
				$config = array();
			}
			static::actsAs($name, $config);
		}
	}

	/**
	 * Transfer static call to the behaviors first.
	 *
	 * @param string $method Method name caught by `__callStatic()`.
	 * @param array $params Arguments given to the above `$method` call.
	 * @return mixed
	 */
	public static function __callStatic($method, $params) {
		$self = static::_object();
		foreach ($self->_behaviors as $class => $behavior) {
			if(method_exists($class, $method)) {
				$model = get_called_class();
				array_unshift($params, $model);
				return call_user_func_array(array($class, $method), $params);
			}
		}
		return parent::__callStatic($method, $params);
	}

	/**
	 * Transfer call from the entity class to the behaviors
	 *
	 * @param string $method Method name caught by `__call()`.
	 * @param array $params Arguments given to the above `$method` call.
	 * @return mixed
	 */
	public function __call($method, $params) {
		$self = static::_object();
		foreach ($self->_behaviors as $class => $behavior) {
			if(method_exists($behavior, $method)) {
				return $behavior->invokeMethod($method, $params);
			}
		}
		parent::__call($method, $params);
	}

	/**
	 * Bind a behavior class to the current model
	 *
	 * @param string $name The name of the behavior
	 * @param string $config If `$config === true` returns some configurations of the behavior,
	 *               if `$config === false` unbind the behavior, otherwise `$config` stands for
	 *               the configuration array to set for the behavior.
	 * @param string $entry The name of the configuration option to get. If `null` all
	 *               configuration options will be returned.
	 *               (this parameter is only applicable if `$config === true`)
	 * @return boolean `true` on success, `false` otherwise
	 */
	public static function actsAs($name, $config = array(), $entry = null) {
		$self = static::_object();

		$class = Libraries::locate('behavior', $name);

		if ($config === true) {
			if (isset($self->_behaviors[$class])) {
				return $self->_behaviors[$class]->config($entry);
			}
			throw new RuntimeException("Unexisting Behavior named `{$class}`.");
		}
		if ($config === false) {
			unset($self->_behaviors[$class]);
			return true;
		}

		$model = get_called_class();
		if (isset($self->_behaviors[$class])) {
			$self->_behaviors[$class]->config($config + compact('model'));
			return true;
		} else {
			$object = new $class($config + compact('model'));
			if ($object) {
				$self->_behaviors[$class] = $object;
				return true;
			}
		}
		return false;
	}
}

?>