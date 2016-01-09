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

namespace BenGor\User\Domain\Event;

use BenGor\User\Domain\Model\UserMailableFactory;
use BenGor\User\Domain\Model\UserMailer;
use Ddd\Domain\DomainEventSubscriber;

/**
 * Abstract user invited mailer subscriber class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
abstract class UserInvitedMailerSubscriber extends DomainEventSubscriber
{
    /**
     * The mailable factory.
     *
     * @var UserMailableFactory
     */
    protected $mailableFactory;

    /**
     * The mailer.
     *
     * @var UserMailer
     */
    protected $mailer;

    /**
     * Constructor.
     *
     * @param UserMailer          $aMailer          The mailer
     * @param UserMailableFactory $aMailableFactory The mailable factory
     */
    public function __construct(UserMailer $aMailer, UserMailableFactory $aMailableFactory)
    {
        $this->mailer = $aMailer;
        $this->mailableFactory = $aMailableFactory;
    }

    /**
     * @inheritdoc}
     */
    public function isSubscribedTo($aDomainEvent)
    {
        return $aDomainEvent instanceof UserInvitedMailerSubscriber;
    }
}
