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
 * Spec file of invite user request class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class InviteUserRequestSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('email@email.com');
        $this->shouldHaveType('BenGor\User\Application\Service\InviteUserRequest');

        $this->email()->shouldBe('email@email.com');
    }
}
