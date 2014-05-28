<?php

namespace spec\Task\Plugin\Behat;

use KashifSaadat\DirectoryManager\DirectoryManager;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArgvInput;

class CommandSpec extends ObjectBehavior
{
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
            ->init()
            ->setLang('en')
            ->setName('Bob')
            ->setTags(['accountLogin','accountReg'])
            ->setRole('something')
            ->appendSnippets()
            ->noSnippets()
            ->strict()
            ->rerun()
            ->stopOnFailure()
            ->dryRun()
            ->setProfile('chrome')
            ->setConfig('custom.behat.yml')
            ->verbose()
            ->colors()
            ->noColors();

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

    function it_should_set_parameters_as_passed()
    {
        $this->setParameters(array(
            '--suite', 'testEnv',
            '--stop-on-failure',
            '--some-new-param'
        ));

        $this->getParameters()->shouldReturn(array(
            '--suite', 'testEnv',
            '--stop-on-failure',
            '--some-new-param'
        ));
    }

    function it_should_prepend_behat_to_cli_arguments()
    {
        $this->add('foo');
        $this->getCliArguments()->shouldReturn(["behat", "foo"]);
    }

    function it_should_create_an_application()
    {
        $this->getApplication()->shouldHaveType('Symfony\Component\Console\Application');
    }

    function it_should_create_a_directory_manager_instance()
    {
        $this->getDirectoryManager()->shouldHaveType('KashifSaadat\DirectoryManager\DirectoryManager');
    }

    function it_should_run_the_application(Application $app, OutputInterface $output, DirectoryManager $directoryManager)
    {
        $this->setDirectoryManager($directoryManager);
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

        $this->setDirectoryManager($directoryManager);
        $this->setApplication($application);
        $this->run($output);
    }
}
