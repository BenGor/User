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

namespace BenGor\User\Infrastructure\Domain\Event\Symfony;

use BenGor\User\Domain\Model\Event\UserRememberPasswordRequested;
use BenGor\User\Domain\Model\UserMailableFactory;
use BenGor\User\Domain\Model\UserMailer;
use Ddd\Domain\DomainEventSubscriber;
use Symfony\Component\Routing\Router;

/**
 * User remember password requested subscriber class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
final class UserRememberPasswordRequestedSubscriber implements DomainEventSubscriber
{
    /**
     * The fully qualified user class name.
     *
     * @var string|null
     */
    private $fqcn;

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
     * The Symfony router component.
     *
     * @var Router
     */
    private $router;

    /**
     * Constructor.
     *
     * @param UserMailer          $aMailer          The mailer
     * @param UserMailableFactory $aMailableFactory The mailable factory
     * @param Router              $aRouter          The Symfony router
     * @param string              $aRoute           The route name
     * @param string|null         $fqcn             The fully qualified user class name
     */
    public function __construct(
        UserMailer $aMailer,
        UserMailableFactory $aMailableFactory,
        Router $aRouter,
        $aRoute,
        $fqcn = null
    ) {
        $this->mailer = $aMailer;
        $this->mailableFactory = $aMailableFactory;
        $this->router = $aRouter;
        $this->route = $aRoute;
        $this->fqcn = $fqcn;
    }

    /**
     * {@inheritdoc}
     *
     * @param UserRememberPasswordRequested $aDomainEvent The domain event
     */
    public function handle($aDomainEvent)
    {
        $user = $aDomainEvent->user();
        $url = $this->router->generate($this->route, ['rememberPasswordToken' => $user->rememberPasswordToken()]);
        $mail = $this->mailableFactory->build($user->email(), [
            'user' => $user, 'url' => $url,
        ]);

        $this->mailer->mail($mail);
    }

    /**
     * @inheritdoc}
     *
     * @param UserRememberPasswordRequested $aDomainEvent The domain event
     */
    public function isSubscribedTo($aDomainEvent)
    {
        if (null !== $this->fqcn && $this->fqcn !== get_class($aDomainEvent->user())) {
            return false;
        }

        return $aDomainEvent instanceof UserRememberPasswordRequested;
    }
}
