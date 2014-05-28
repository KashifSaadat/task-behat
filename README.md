task/behat
============

Example
=======

```php
use Task\Plugin\BehatPlugin;

$project->inject(function ($container) {
    $container['behat'] = new BehatPlugin;
});


$project->addTask('behat', 'Run Behat UI tests against testEnv with login & reg tags', ['behat', function ($behat) {
    $behat->create('php/tests/behat/ui', 'testEnv', 'login,reg')
        ->setFormat('progress')
        ->pipe($this->getOutput()
    );
}]);


```

Installation
============

Add to your `composer.json`:
```json
...
"require-dev": {
    "task/behat": "~0.1"
}
...
```

Usage
=====
See [task/console](https://github.com/taskphp/console) for usage documentation.