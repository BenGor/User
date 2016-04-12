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

namespace spec\BenGor\User\Domain\Event;

use BenGor\User\Domain\Event\UserRegisteredMailerSubscriber;
use BenGor\User\Domain\Model\Event\UserInvited;
use BenGor\User\Domain\Model\Event\UserRegistered;
use BenGor\User\Domain\Model\User;
use BenGor\User\Domain\Model\UserEmail;
use BenGor\User\Domain\Model\UserGuest;
use BenGor\User\Domain\Model\UserGuestId;
use BenGor\User\Domain\Model\UserId;
use BenGor\User\Domain\Model\UserMailable;
use BenGor\User\Domain\Model\UserMailableFactory;
use BenGor\User\Domain\Model\UserMailer;
use BenGor\User\Domain\Model\UserPassword;
use BenGor\User\Domain\Model\UserRole;
use BenGor\User\Domain\Model\UserUrlGenerator;
use Ddd\Domain\DomainEventSubscriber;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Spec file of UserRegisteredMailerSubscriber class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class UserRegisteredMailerSubscriberSpec extends ObjectBehavior
{
    function let(UserMailer $mailer, UserMailableFactory $mailableFactory, UserUrlGenerator $urlGenerator)
    {
        $this->beConstructedWith($mailer, $mailableFactory, $urlGenerator, 'bengor_user_user_enable');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserRegisteredMailerSubscriber::class);
    }

    function it_implements_domain_event_subscriber()
    {
        $this->shouldImplement(DomainEventSubscriber::class);
    }

    function it_handles(UserUrlGenerator $urlGenerator, UserMailableFactory $mailableFactory)
    {
        $domainEvent = new UserRegistered(
            new User(
                new UserId(),
                new UserEmail('bengor@user.com'),
                UserPassword::fromEncoded('endoced-password', 'salt'),
                [new UserRole('ROLE_USER')]
            )
        );
        $mailable = new UserMailable(
            new UserEmail('benatespina@gmail.com'),
            new UserEmail('bengor@user.com'),
            'Dummy mail',
            'Dummy mail body text'
        );

        $urlGenerator->generate(
            'bengor_user_user_enable', Argument::type('array')
        )->shouldBeCalled()->willReturn('bengor.user.com/user/enable');
        $mailableFactory->build(
            'bengor@user.com', Argument::type('array')
        )->shouldBeCalled()->willReturn($mailable);

        $this->handle($domainEvent);
    }

    function it_is_subscribe_to()
    {
        $registeredDomainEvent = new UserRegistered(
            new User(
                new UserId(),
                new UserEmail('bengor@user.com'),
                UserPassword::fromEncoded('endoced-password', 'salt'),
                [new UserRole('ROLE_USER')]
            )
        );
        $invitedDomainEvent = new UserInvited(
            new UserGuest(
                new UserGuestId(),
                new UserEmail('bengor@user.com')
            )
        );

        $this->isSubscribedTo($registeredDomainEvent)->shouldReturn(true);
        $this->isSubscribedTo($invitedDomainEvent)->shouldReturn(false);
    }

    function it_is_subscribe_to_with_user_class(
        UserMailer $mailer,
        UserMailableFactory $mailableFactory,
        UserUrlGenerator $urlGenerator
    ) {
        $this->beConstructedWith(
            $mailer,
            $mailableFactory,
            $urlGenerator,
            'bengor_user_user_enable',
            UserGuest::class
        );

        $registeredDomainEvent = new UserRegistered(
            new User(
                new UserId(),
                new UserEmail('bengor@user.com'),
                UserPassword::fromEncoded('endoced-password', 'salt'),
                [new UserRole('ROLE_USER')]
            )
        );

        $this->isSubscribedTo($registeredDomainEvent)->shouldReturn(false);
    }
}
