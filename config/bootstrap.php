<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use lithium\core\Libraries;

/**
 * This adds the `'behavior'` type to the list of recognized class types. You can look up the
 * behaviors available to your application by running `Libraries::locate('behavior')`.
 */
Libraries::paths([
	'behavior' => ['{:library}\extensions\data\behavior\{:name}']
]);

?>