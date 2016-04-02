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

namespace BenGor\User\Application\DataTransformer;

use BenGor\User\Domain\Model\User;

/**
 * User data transformer.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
interface UserDataTransformer
{
    /**
     * Writes the high level user domain concepts.
     *
     * @param User $aUser The user
     */
    public function write(User $aUser);

    /**
     * Reads the low level user infrastructure details.
     *
     * @return mixed
     */
    public function read();
}
