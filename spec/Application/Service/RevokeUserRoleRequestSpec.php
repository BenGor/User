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

namespace spec\BenGor\User\Application\Service;

use PhpSpec\ObjectBehavior;

/**
 * Spec file of revoke user role request class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class RevokeUserRoleRequestSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('user-id', ['ROLE_USER']);
        $this->shouldHaveType('BenGor\User\Application\Service\RevokeUserRoleRequest');

        $this->id()->shouldReturn('user-id');
        $this->role()->shouldReturn(['ROLE_USER']);
    }
}
