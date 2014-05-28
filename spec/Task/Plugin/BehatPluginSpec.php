<?php

namespace spec\Task\Plugin;

use PhpSpec\ObjectBehavior;

class BehatPluginSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Task\Plugin\BehatPlugin');

    }

    function it_should_create_a_command()
    {
        $this->build()->shouldReturnAnInstanceOf('Task\Plugin\Behat\Command');
    }

    function it_should_create_a_command_with_set_parameters()
    {
        $command = $this->create('php/tests/behat/ui', 'testEnv', 'accountLogin,accountReg');
        $command->shouldBeAnInstanceOf('Task\Plugin\Behat\Command');
        $command->getWorkingDirectory()->shouldBeEqualTo('php/tests/behat/ui');
        $command->getParameters()->shouldReturn(['--suite', 'testEnv', '--tags', 'accountLogin,accountReg']);
    }
}
