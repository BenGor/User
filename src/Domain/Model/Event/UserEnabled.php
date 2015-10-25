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

namespace BenGor\User\Domain\Model\Event;

use BenGor\User\Domain\Model\User;
use Ddd\Domain\DomainEvent;
use Ddd\Domain\Event\PublishableDomainEvent;

/**
 * User enabled domain event class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
final class UserEnabled implements DomainEvent, PublishableDomainEvent
{
    /**
     * The user.
     *
     * @var User
     */
    private $user;

    /**
     * Constructor.
     *
     * @param User $aUser The user
     */
    public function __construct(User $aUser)
    {
        $this->user = $aUser;
        $this->occurredOn = new \DateTime();
    }

    /**
     * Gets the user.
     *
     * @return User
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Gets the occurred on.
     *
     * @return \DateTime
     */
    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
