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

use BenGor\User\Application\Service\ChangeUserPasswordRequest;
use BenGor\User\Domain\Model\User;
use BenGor\User\Domain\Model\UserPassword;
use BenGor\User\Domain\Model\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\BenGor\User\Domain\Model\DummyUserPasswordEncoder;

/**
 * Spec file of change user password service class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ChangeUserPasswordServiceSpec extends ObjectBehavior
{
    function let(UserRepository $repository)
    {
        $encoder = new DummyUserPasswordEncoder('encodedPassword');
        $this->beConstructedWith($repository, $encoder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('BenGor\User\Application\Service\ChangeUserPasswordService');
    }

    function it_changes_password(UserRepository $repository, User $user)
    {
        $request = new ChangeUserPasswordRequest('id', 'newPassword', 'oldPassword');

        $user->password()->shouldBeCalled()->willReturn(
            UserPassword::fromPlain('oldPassword', new DummyUserPasswordEncoder('encodedPassword'))
        );
        $user->changePassword(
            Argument::type('BenGor\User\Domain\Model\UserPassword'),
            Argument::type('BenGor\User\Domain\Model\UserPassword')
        )->shouldBeCalled();

        $repository->userOfId(Argument::type('BenGor\User\Domain\Model\UserId'))
            ->shouldBeCalled()->willReturn($user);
        $repository->persist($user)->shouldBeCalled();

        $this->execute($request);
    }
}
