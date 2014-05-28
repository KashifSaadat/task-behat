<?php

namespace Task\Plugin\Behat;

use KashifSaadat\DirectoryManager\DirectoryManager;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\OutputInterface;
use Task\Plugin\Console\Output\ProxyOutput;

class Command
{
    protected $application;
    protected $directoryManager;
    protected $workingDirectory;
    protected $parameters = [];

    public function getApplication()
    {
        if (!$this->application) {
            $this->application = (new \Behat\Behat\ApplicationFactory())->createApplication();
        }

        return $this->application;
    }

    public function setApplication(Application $application)
    {
        $this->application = $application;
        return $this;
    }

    public function getDirectoryManager()
    {
        if (!$this->directoryManager) {
            $this->directoryManager = new DirectoryManager;
        }

        return $this->directoryManager;
    }

    public function setDirectoryManager(DirectoryManager $directoryManager)
    {
        $this->directoryManager = $directoryManager;
        return $this;
    }

    public function getCliArguments()
    {
        return array_merge(['behat'], $this->getParameters());
    }

    public function run(OutputInterface $output = null)
    {
        if ($this->workingDirectory) {
            $this->getDirectoryManager()->cd($this->workingDirectory);
        }

        $input = new ArgvInput($this->getCliArguments());
        $exitCode = $this->getApplication()->run($input, $output);

        $this->getDirectoryManager()->reset();
        return $exitCode;
    }

    public function pipe($to)
    {
        if ($to instanceof OutputInterface) {
            $this->run($to);
            return $to;
        } else {
            return $this->pipe((new ProxyOutput)->setTarget($to));
        }
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function add()
    {
        $this->parameters = array_merge($this->parameters, func_get_args());
        return $this;
    }

    public function setWorkingDirectory($workingDirectory)
    {
        $this->workingDirectory = $workingDirectory;
        return $this;
    }

    public function getWorkingDirectory()
    {
        return $this->workingDirectory;
    }

    public function setSuite($suite)
    {
        return $this->add('--suite', $suite);
    }

    public function setFormat($format)
    {
        return $this->add('--format', $format);
    }

    public function setOut($outputDir)
    {
        return $this->add('--out', $outputDir);
    }

    public function init()
    {
        return $this->add('--init');
    }

    public function setLang($language)
    {
        return $this->add('--lang', $language);
    }

    public function setName($names)
    {
        return $this->add('--name', $names);
    }

    public function setTags(array $tags)
    {
        return $this->add('--tags', implode(',', $tags));
    }

    public function setRole($role)
    {
        return $this->add('--role', $role);
    }

    public function appendSnippets()
    {
        return $this->add('--append-snippets');
    }

    public function noSnippets()
    {
        return $this->add('--no-snippets');
    }

    public function strict()
    {
        return $this->add('--strict');
    }

    public function rerun()
    {
        return $this->add('--rerun');
    }

    public function stopOnFailure()
    {
        return $this->add('--stop-on-failure');
    }

    public function dryRun()
    {
        return $this->add('--dry-run');
    }

    public function setProfile($profile)
    {
        return $this->add('--profile', $profile);
    }

    public function setConfig($config)
    {
        return $this->add('--config', $config);
    }

    public function verbose()
    {
        return $this->add('-v');
    }

    public function colors()
    {
        return $this->add('--colors');
    }

    public function noColors()
    {
        return $this->add('--no-colors');
    }
}
