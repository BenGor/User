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

namespace spec\BenGor\User\Application\Service\RequestRememberPassword;

use BenGor\User\Application\Service\RequestRememberPassword\RequestRememberPasswordRequest;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of request remember password request class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class RequestRememberPasswordRequestSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('test@test.com');
        $this->shouldHaveType(RequestRememberPasswordRequest::class);

        $this->email()->shouldBe('test@test.com');
    }
}
