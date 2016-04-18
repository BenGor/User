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

namespace spec\BenGor\User\Application\Service\LogOut;

use BenGor\User\Application\Service\LogOut\LogOutUserRequest;
use BenGor\User\Application\Service\LogOut\LogOutUserService;
use BenGor\User\Domain\Model\Exception\UserDoesNotExistException;
use BenGor\User\Domain\Model\User;
use BenGor\User\Domain\Model\UserId;
use BenGor\User\Domain\Model\UserRepository;
use Ddd\Application\Service\ApplicationService;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of logout user service class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class LogOutUserServiceSpec extends ObjectBehavior
{
    function let(UserRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LogOutUserService::class);
    }

    function it_implements_application_service()
    {
        $this->shouldImplement(ApplicationService::class);
    }

    function it_logs_the_user_out(UserRepository $repository, User $user, LogOutUserRequest $request)
    {
        $request->id()->shouldBeCalled()->willReturn('user-id');

        $repository->userOfId(new UserId('user-id'))->shouldBeCalled()->willReturn($user);

        $user->logout()->shouldBeCalled();

        $repository->persist($user)->shouldBeCalled();

        $this->execute($request);
    }

    function it_does_not_logout_unknown_user(UserRepository $repository, LogOutUserRequest $request)
    {
        $request->id()->shouldBeCalled()->willReturn('user-id');
        $repository->userOfId(new UserId('user-id'))->shouldBeCalled()->willReturn(null);

        $this->shouldThrow(UserDoesNotExistException::class)->duringExecute($request);
    }
}
