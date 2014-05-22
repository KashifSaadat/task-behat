<?php

namespace Task\Plugin;

class BehatPlugin implements PluginInterface
{
    public function __construct()
    {
        if (extension_loaded('xdebug') && ini_get('xdebug.max_nesting_level') <= 150) {
            ini_set('xdebug.max_nesting_level', 150);
        }
    }

    public function build()
    {
        return new Behat\Command();
    }

    public function create($workingDirectory = '.', $suite = null, $tags = [])
    {
        $command = $this->build();
        $command->setWorkingDirectory($workingDirectory);

        if ($suite) {
            $command->setSuite($suite);
        }

        if ($tags) {
            if (is_string($tags)) {
                $tags = explode(',', $tags);
            }

            $command->setTags($tags);
        }

        return $command;
    }
}
