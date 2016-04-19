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

namespace spec\BenGor\User\Application\Service\Remove;

use BenGor\User\Application\Service\Remove\RemoveUserRequest;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of RemoveUserRequest class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class RemoveUserRequestSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('a-plain-string-id');
        $this->shouldHaveType(RemoveUserRequest::class);
        $this->id()->shouldReturn('a-plain-string-id');
    }
}
