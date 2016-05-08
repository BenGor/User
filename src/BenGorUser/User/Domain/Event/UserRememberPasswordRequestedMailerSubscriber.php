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

namespace BenGorUser\User\Domain\Event;

use BenGorUser\User\Domain\Model\Event\UserEvent;
use BenGorUser\User\Domain\Model\Event\UserRememberPasswordRequested;
use BenGorUser\User\Domain\Model\UserMailableFactory;
use BenGorUser\User\Domain\Model\UserMailer;
use BenGorUser\User\Domain\Model\UserUrlGenerator;

/**
 * User remember password requested mailer subscriber class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class UserRememberPasswordRequestedMailerSubscriber implements UserEventSubscriber
{
    /**
     * The fully qualified user class name.
     *
     * @var string|null
     */
    private $userClass;

    /**
     * The mailable factory.
     *
     * @var UserMailableFactory
     */
    private $mailableFactory;

    /**
     * The mailer.
     *
     * @var UserMailer
     */
    private $mailer;

    /**
     * The route name.
     *
     * @var string
     */
    private $route;

    /**
     * The url generator.
     *
     * @var UserUrlGenerator
     */
    private $urlGenerator;

    /**
     * Constructor.
     *
     * @param UserMailer          $aMailer          The mailer
     * @param UserMailableFactory $aMailableFactory The mailable factory
     * @param UserUrlGenerator    $anUrlGenerator   The url generator
     * @param string              $aRoute           The route name
     * @param string|null         $aUserClass       The fully qualified user class name
     */
    public function __construct(
        UserMailer $aMailer,
        UserMailableFactory $aMailableFactory,
        UserUrlGenerator $anUrlGenerator,
        $aRoute,
        $aUserClass = null
    ) {
        $this->mailer = $aMailer;
        $this->mailableFactory = $aMailableFactory;
        $this->urlGenerator = $anUrlGenerator;
        $this->route = $aRoute;
        $this->userClass = $aUserClass;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(UserEvent $anEvent)
    {
        $user = $anEvent->user();
        $url = $this->urlGenerator->generate($this->route, [
            'remember-password-token' => $user->rememberPasswordToken()->token(),
        ]);
        $mail = $this->mailableFactory->build($user->email(), [
            'user' => $user, 'url' => $url,
        ]);

        $this->mailer->mail($mail);
    }

    /**
     * {@inheritdoc}
     */
    public function isSubscribedTo(UserEvent $anEvent)
    {
        if (null !== $this->userClass && $this->userClass !== get_class($anEvent->user())) {
            return false;
        }

        return $anEvent instanceof UserRememberPasswordRequested;
    }
}
