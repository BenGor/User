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
 * User not transformation data transformer.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class UserNoTransformationDataTransformer implements UserDataTransformer
{
    /**
     * The domain user.
     *
     * @var User
     */
    private $user;

    /**
     * {@inheritdoc}
     */
    public function write(User $aUser)
    {
        $this->user = $aUser;
    }

    /**
     * {@inheritdoc}
     */
    public function read()
    {
        if (null === $this->user) {
            return [];
        }

        return $this->user;
    }
}
