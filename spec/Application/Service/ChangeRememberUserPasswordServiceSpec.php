<?php

/*
 * This file is part of the User library.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\BenGor\User\Application\Service;

use BenGor\User\Application\Service\ChangeRememberUserPasswordRequest;
use BenGor\User\Domain\Model\Exception\UserDoesNotExistException;
use BenGor\User\Domain\Model\User;
use BenGor\User\Domain\Model\UserPassword;
use BenGor\User\Domain\Model\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\BenGor\User\Domain\Model\DummyUserPasswordEncoder;

/**
 * Spec file of change remember user password service class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ChangeRememberUserPasswordServiceSpec extends ObjectBehavior
{
    function let(UserRepository $repository)
    {
        $encoder = new DummyUserPasswordEncoder('encodedPassword');
        $this->beConstructedWith($repository, $encoder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('BenGor\User\Application\Service\ChangeRememberUserPasswordService');
    }

    function it_restores_password(UserRepository $repository, User $user)
    {
        $request = new ChangeRememberUserPasswordRequest('newPassword', 'dummy-remember-password-token');
        $encoder = new DummyUserPasswordEncoder('encodedPassword');
        $oldPassword = UserPassword::fromPlain('oldPassword', $encoder);

        $repository->userOfRememberPasswordToken($request->rememberPasswordToken())
            ->shouldBeCalled()->willReturn($user);

        $user->password()->shouldBeCalled()->willReturn($oldPassword);
        $user->changePassword(
            $oldPassword,
            Argument::type('BenGor\User\Domain\Model\UserPassword')
        )->shouldBeCalled();

        $repository->persist($user)->shouldBeCalled();

        $this->execute($request);
    }

    function it_does_not_restore_password_because_user_does_not_exist(UserRepository $repository)
    {
        $request = new ChangeRememberUserPasswordRequest('newPassword', 'dummy-remember-password-token');

        $repository->userOfRememberPasswordToken($request->rememberPasswordToken())->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(new UserDoesNotExistException())->duringExecute($request);
    }
}
