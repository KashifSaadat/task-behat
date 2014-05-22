<?php

namespace spec\Task\Plugin\Behat;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Task\Plugin\Behat\DirectoryManager;

class CommandSpec extends ObjectBehavior
{
    function let(DirectoryManager $directoryManager)
    {
        $this->setDirectoryManager($directoryManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Task\Plugin\Behat\Command');
    }

    function it_should_add_arguments()
    {
        $this
            ->setSuite('testEnv')
            ->setFormat('someFormat')
            ->setOut('/tmp/outputLocation')
            ->initSuites()
            ->setLang('en')
            ->setName('Bob')
            ->setTags(['accountLogin','accountReg'])
            ->setRole('something')
            ->appendSnippets()
            ->noSnippets()
            ->setStrict()
            ->setRerun()
            ->setStopOnFailure()
            ->setDryRun()
            ->setProfile('chrome')
            ->setConfig('custom.behat.yml')
            ->setVerbose()
            ->setColors()
            ->setNoColors();

        $parameters = [
            '--suite', 'testEnv',
            '--format', 'someFormat',
            '--out', '/tmp/outputLocation',
            '--init',
            '--lang', 'en',
            '--name', 'Bob',
            '--tags', 'accountLogin,accountReg',
            '--role', 'something',
            '--append-snippets',
            '--no-snippets',
            '--strict',
            '--rerun',
            '--stop-on-failure',
            '--dry-run',
            '--profile', 'chrome',
            '--config', 'custom.behat.yml',
            '-v',
            '--colors',
            '--no-colors'
        ];

        $this->getParameters()->shouldReturn($parameters);
    }

    function it_should_prepend_behat_to_cli_arguments()
    {
        $this->add('foo');
        $this->getCliArguments()->shouldReturn(["behat", "foo"]);
    }

    function it_should_run_the_application(Application $app, OutputInterface $output)
    {
        $this->setApplication($app);

        $input = new ArgvInput(['behat']);
        $app->run($input, $output)->willReturn(123);

        $this->run($output)->shouldReturn(123);
    }

    function it_should_change_to_working_directory(Application $application, OutputInterface $output, DirectoryManager $directoryManager)
    {
        $this->setWorkingDirectory('/tmp');
        $directoryManager->cd('/tmp')->shouldBeCalled();
        $directoryManager->reset()->shouldBeCalled();

        $this->setApplication($application);
        $this->run($output);
    }
}
