<?php

declare(strict_types=1);

namespace BaBeuloula\Tests\Constraint;

use BaBeuloula\Constraint\Password;

class PasswordDummy
{
    #[Password]
    private $a;

    #[Password(min: 8, minMessage: 'myMessage')]
    private $b;

    #[Password(letters: true, lettersMessage: 'myMessage', groups: ['my_group'])]
    private $c;
}
