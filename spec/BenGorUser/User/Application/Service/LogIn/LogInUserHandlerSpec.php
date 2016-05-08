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

namespace spec\BenGorUser\User\Application\Service\LogIn;

use BenGorUser\User\Application\Service\LogIn\LogInUserCommand;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of log in user request class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class LogInUserHandlerSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('user@user.net', 'plainPassword');
        $this->shouldHaveType(LogInUserCommand::class);

        $this->email()->shouldReturn('user@user.net');
        $this->password()->shouldReturn('plainPassword');
    }
}
