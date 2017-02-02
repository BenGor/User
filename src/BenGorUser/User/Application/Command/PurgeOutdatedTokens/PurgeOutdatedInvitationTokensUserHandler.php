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

namespace BenGorUser\User\Application\Command\PurgeOutdatedTokens;

use BenGorUser\User\Domain\Model\Exception\UserTokenNotFoundException;
use BenGorUser\User\Domain\Model\UserRepository;

/**
 * Purge outdated invitation tokens command handler class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class PurgeOutdatedInvitationTokensUserHandler
{
    /**
     * The user repository.
     *
     * @var UserRepository
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param UserRepository $aRepository The user repository
     */
    public function __construct(UserRepository $aRepository)
    {
        $this->repository = $aRepository;
    }

    /**
     * Handles the given command.
     *
     * @param PurgeOutdatedInvitationTokensUserCommand $aCommand The command
     */
    public function __invoke(PurgeOutdatedInvitationTokensUserCommand $aCommand)
    {
        $users = $this->repository->all();
        foreach ($users as $user) {
            try {
                $user->cleanInvitationToken();
            } catch (UserTokenNotFoundException $exception) {
                continue;
            }
            $this->repository->persist($user);
        }
    }
}
