# Model behaviors base classes

## Requirement

PHP 5.4

## Installation

Checkout the code to either of your library directories:

```
cd libraries
git clone git@github.com:jails/li3_behaviors.git
```

Include the library in your `/app/config/bootstrap/libraries.php`

```
Libraries::add('li3_behaviors');
```

## Presentation

Model behaviors providing a simple way to extend models. This pattern allow common logic to be encapsulated inside behaviors for keeping models lite and composed only by its own business logic.

## API

Simple model creation attached to a behavior:

```php
<?php
//app/models/Posts.php
namespace app\models;
use li3_behaviors\data\model\Behaviors;

class Posts extends \lithium\data\Model {
    use Behaviors;

    protected $_actsAs = ['Slug' => [
        'fields' => ['title' => 'title', 'name' => 'slug']
    ]];
}
?>
```

```php
<?php
//app/extensions/data/behavior/Slug.php
namespace app\extensions\data\behavior;

use lithium\util\Inflector;

class Slug extends \li3_behaviors\data\model\Behavior {

	public function __construct(array $config = []) {
		$defaults = [
			'fields' => ['label' => 'slug']
		];
		parent::__construct($config + $defaults);
	}

	protected function _init() {
		parent::_init();
		if ($model = $this->_model) {
			$behavior = $this;
			$model::applyFilter('save', function($self, $params, $chain) use ($behavior) {
				$params = $behavior->invokeMethod('_slug', array($params));
				return $chain->next($self, $params, $chain);
			});
		}
	}

	protected function _slug() {
		extract($this->_config);
		foreach ($fields as $from => $to) {
			if (isset($params['data'][$from])) {
				$params['data'][$to] = Inflector::slug($params['data'][$from]);
			}
		}
	}
}
?>
```

## Greetings

The li3 team, Nateabele's filters system and all others which make that possible (including my parents which I love).

## Build status
[![Build Status](https://secure.travis-ci.org/jails/li3_behaviors.png?branch=master)](http://travis-ci.org/jails/li3_behaviors)
