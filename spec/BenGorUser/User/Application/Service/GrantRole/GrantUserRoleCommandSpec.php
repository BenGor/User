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

namespace spec\BenGorUser\User\Application\Service\GrantRole;

use BenGorUser\User\Application\Service\GrantRole\GrantUserRoleCommand;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of grant user role request class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class GrantUserRoleCommandSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('user-id', ['ROLE_USER']);
        $this->shouldHaveType(GrantUserRoleCommand::class);

        $this->id()->shouldReturn('user-id');
        $this->role()->shouldReturn(['ROLE_USER']);
    }
}
