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

namespace spec\BenGor\User\Application\Service\SignUp;

use BenGor\User\Application\Service\SignUp\DefaultSignUpUserSpecification;
use BenGor\User\Application\Service\SignUp\SignUpUserRequest;
use BenGor\User\Application\Service\SignUp\SignUpUserSpecification;
use BenGor\User\Domain\Model\User;
use BenGor\User\Domain\Model\UserEmail;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of default sign up user specification class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class DefaultSignUpUserSpecificationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DefaultSignUpUserSpecification::class);
    }

    function it_implements_sign_up_user_specification()
    {
        $this->shouldImplement(SignUpUserSpecification::class);
    }

    function it_gets_email(SignUpUserRequest $request)
    {
        $request->email()->shouldBeCalled()->willReturn('user@user.com');

        $this->email($request)->shouldReturnAnInstanceOf(UserEmail::class);
    }

    function it_pre_persists(User $user)
    {
        $user->enableAccount()->shouldBeCalled();

        $this->prePersist($user)->shouldReturn($user);
    }
}
