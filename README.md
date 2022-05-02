# Password Constraint

Password constraint for Symfony. Based on the [validator of Laravel framework][based]. It's recommended to use with
[NotCompromisedPassword][NotCompromisedPassword] constraint.

[based]: https://github.com/laravel/framework/blob/9.x/src/Illuminate/Validation/Rules/Password.php
[NotCompromisedPassword]: https://symfony.com/doc/current/reference/constraints/NotCompromisedPassword.html

## Requirements

- php >= 8.1
- symfony/validator >= 6.0

## Installation

```bash
composer require babeuloula/password-constraint
```

## How to use?

```php
use BaBeuloula\Constraint\Password;

class PasswordDummy
{
    #[Password]
    private $a;

    #[Password(min: 8, minMessage: 'myMessage')]
    private $b;

    #[Password(letters: true, lettersMessage: 'myMessage', groups: ['my_group'])]
    private $c;
```

- min (12): The minimum size of the password.
- mixedCase (false): If the password requires at least one uppercase and one lowercase letter.
- letters (false): If the password requires at least one letter.
- numbers (false): If the password requires at least one number.
- symbols (false): If the password requires at least one symbol.
