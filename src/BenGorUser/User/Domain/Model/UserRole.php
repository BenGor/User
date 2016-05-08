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

/**
 * User role domain class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
final class UserRole
{
    /**
     * The role in plain string.
     *
     * @var string
     */
    private $role;

    /**
     * Constructor.
     *
     * @param string $aRole A role in primitive string
     */
    public function __construct($aRole)
    {
        $this->role = $aRole;
    }

    /**
     * Gets the role.
     *
     * @return string
     */
    public function role()
    {
        return $this->role;
    }

    /**
     * Method that checks if the user role given is equal to the current.
     *
     * @param UserRole $aRole The user role
     *
     * @return bool
     */
    public function equals(UserRole $aRole)
    {
        return strtolower($this->role) === strtolower($aRole->role());
    }

    /**
     * Magic method that represents the user role in string format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->role;
    }
}
