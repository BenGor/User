<?php

/*
 * This file is part of the BenGorUser library.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\BenGor\User\Application\Service\LogIn;

use BenGor\User\Application\Service\LogIn\LogInUserRequest;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of log in user request class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class LogInUserRequestSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('user@user.net', 'plainPassword');
        $this->shouldHaveType(LogInUserRequest::class);

        $this->email()->shouldReturn('user@user.net');
        $this->password()->shouldReturn('plainPassword');
    }
}
