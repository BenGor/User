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

namespace spec\BenGor\User\Application\Service\ChangePassword;

use BenGor\User\Application\Service\ChangePassword\ChangeUserPasswordRequest;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of change user password request class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ChangeUserPasswordRequestSpec extends ObjectBehavior
{
    function it_creates_request_from_default()
    {
        $this->beConstructedFrom('id', 'newPassword', 'oldPassword');
        $this->shouldHaveType(ChangeUserPasswordRequest::class);

        $this->id()->shouldReturn('id');
        $this->newPlainPassword()->shouldReturn('newPassword');
        $this->oldPlainPassword()->shouldReturn('oldPassword');
        $this->rememberPasswordToken()->shouldReturn(null);
    }

    function it_creates_request_from_remember_password_token()
    {
        $this->beConstructedFromRememberPasswordToken('newPassword', 'remember-password-token');
        $this->shouldHaveType(ChangeUserPasswordRequest::class);

        $this->newPlainPassword()->shouldReturn('newPassword');
        $this->rememberPasswordToken()->shouldReturn('remember-password-token');
        $this->id()->shouldReturn(null);
        $this->oldPlainPassword()->shouldReturn(null);
    }
}
