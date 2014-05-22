<?php

namespace Task\Plugin\Behat;

class DirectoryManager
{
    protected $paths;

    public function __construct()
    {
        $this->paths = new \SplDoublyLinkedList;
    }

    public function cd($path)
    {
        $this->getPaths()->push($this->getCwd());
        chdir($path);
    }

    public function reset()
    {
        if ($path = $this->getPaths()->pop()) {
            chdir($path);
        }
    }

    public function getCwd()
    {
        return getcwd();
    }

    public function getPaths()
    {
        return $this->paths;
    }
}
