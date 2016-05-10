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

namespace BenGorUser\User\Domain\Model;

use BenGorUser\User\Domain\Model\Exception\UserIdInvalidException;
use Ramsey\Uuid\Uuid;

/**
 * User id domain class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
final class UserId
{
    /**
     * The id in a primitive type.
     *
     * @var string|int
     */
    private $id;

    /**
     * Constructor.
     *
     * @param string|int|null $anId The id in a primitive type
     *
     * @throws UserIdInvalidException when the id is not valid
     */
    public function __construct($anId = null)
    {
        if ($anId !== null && !is_scalar($anId)) {
            throw new UserIdInvalidException();
        }
        $this->id = null === $anId ? Uuid::uuid4()->toString() : $anId;
    }

    /**
     * Gets the id.
     *
     * @return string|int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Method that checks if the id given is equal to the current.
     *
     * @param UserId $anId The id
     *
     * @return bool
     */
    public function equals(UserId $anId)
    {
        return $this->id() === $anId->id();
    }

    /**
     * Magic method that represents the user id in string format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
