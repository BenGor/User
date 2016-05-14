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

namespace spec\BenGorUser\User\Application\Service\SignUp;

use BenGorUser\User\Application\DataTransformer\UserDataTransformer;
use BenGorUser\User\Application\Service\SignUp\WithConfirmationSignUpUserCommand;
use BenGorUser\User\Application\Service\SignUp\WithConfirmationSignUpUserHandler;
use BenGorUser\User\Domain\Model\Exception\UserAlreadyExistException;
use BenGorUser\User\Domain\Model\User;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserFactory;
use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserPassword;
use BenGorUser\User\Domain\Model\UserRepository;
use BenGorUser\User\Domain\Model\UserRole;
use BenGorUser\User\Infrastructure\Security\DummyUserPasswordEncoder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Spec file of WithConfirmationSignUpUserHandler class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class WithConfirmationSignUpUserHandlerSpec extends ObjectBehavior
{
    function let(UserRepository $repository, UserFactory $factory, UserDataTransformer $dataTransformer)
    {
        $this->beConstructedWith(
            $repository,
            new DummyUserPasswordEncoder('encoded-password'),
            $factory,
            $dataTransformer
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(WithConfirmationSignUpUserHandler::class);
    }

    function it_signs_the_user_up(
        WithConfirmationSignUpUserCommand $command,
        UserRepository $repository,
        UserFactory $factory,
        UserDataTransformer $dataTransformer,
        User $user,
        \DateTimeImmutable $createdOn,
        \DateTimeImmutable $lastLogin,
        \DateTimeImmutable $updatedOn
    ) {
        $command->email()->shouldBeCalled()->willReturn('user@user.com');
        $email = new UserEmail('user@user.com');
        $repository->userOfEmail($email)->shouldBeCalled()->willReturn(null);

        $id = new UserId('user-id');
        $repository->nextIdentity()->shouldBeCalled()->willReturn($id);

        $command->password()->shouldBeCalled()->willReturn('plain-password');

        $command->roles()->shouldBeCalled()->willReturn(['ROLE_USER']);
        $roles = [new UserRole('ROLE_USER')];

        $factory->register(
            $id, $email, Argument::type(UserPassword::class), $roles
        )->shouldBeCalled()->willReturn($user);
        $repository->persist($user)->shouldBeCalled();
        $dataTransformer->write($user)->shouldBeCalled();
        $dataTransformer->read()->shouldBeCalled()->willReturn([
            'id'                      => 'user-id',
            'confirmation_token'      => null,
            'created_on'              => $createdOn,
            'email'                   => 'user@user.com',
            'last_login'              => $lastLogin,
            'password'                => 'encoded-password',
            'remember_password_token' => null,
            'roles'                   => ['ROLE_USER'],
            'updated_on'              => $updatedOn,
        ]);

        $this->__invoke($command);
    }

    function it_does_not_sign_up_if_user_exists(
        WithConfirmationSignUpUserCommand $command,
        UserRepository $repository,
        User $user
    ) {
        $command->email()->shouldBeCalled()->willReturn('user@user.com');
        $email = new UserEmail('user@user.com');
        $repository->userOfEmail($email)->shouldBeCalled()->willReturn($user);

        $this->shouldThrow(UserAlreadyExistException::class)->during__invoke($command);
    }
}
