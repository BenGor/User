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

namespace spec\BenGorUser\User\Application\Service\Invite;

use BenGorUser\User\Application\Service\Invite\InviteUserCommand;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of invite user request class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class InviteUserCommandSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('email@email.com');
        $this->shouldHaveType(InviteUserCommand::class);

        $this->email()->shouldBe('email@email.com');
    }
}
