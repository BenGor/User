<?php

/*
 * This file is part of the BenGorUser package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\BenGorUser\User\Application\Command\LogIn;

use BenGorUser\User\Application\Command\LogIn\LogInUserCommand;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of LogInUserCommand class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class LogInUserCommandSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('user@user.net', 'plainPassword');
        $this->shouldHaveType(LogInUserCommand::class);

        $this->email()->shouldReturn('user@user.net');
        $this->password()->shouldReturn('plainPassword');
    }
}
