<?php

declare(strict_types=1);

namespace BaBeuloula\Tests\Constraint;

use BaBeuloula\Constraint\Password;
use BaBeuloula\Constraint\PasswordValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @author BaBeuloula <info@babeuloula.fr>
 */
class PasswordValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): PasswordValidator
    {
        return new PasswordValidator();
    }

    /**
     * @param array<string, string> $violations
     *
     * @dataProvider invalidPasswordProvider
     */
    public function testInvalidPassword(?string $value, Password $contraint, array $violations): void
    {
        $this->validator->validate($value, $contraint);

        $assert = $this;
        $assertMethod = 'buildViolation';

        foreach ($violations as $code => $violation) {
            if (Password::MIN_ERROR === $code) {
                $assert = $assert->$assertMethod($contraint->minMessage)
                    ->setParameter('{{ min }}', (string) $contraint->min)
                    ->setCode(Password::MIN_ERROR)
                    ->setInvalidValue($value)
                ;
            } else {
                $assert = $assert->$assertMethod($violation)
                    ->setCode($code)
                    ->setInvalidValue($value)
                ;
            }

            $assertMethod = 'buildNextViolation';
        }

        $assert->assertRaised();
    }

    public function invalidPasswordProvider(): \Generator
    {
        $passwordConstraint = new Password();

        yield [
            null,
            new Password(),
            [
                Password::MIN_ERROR => $passwordConstraint->minMessage,
            ],
        ];

        yield [
            '',
            new Password(
                mixedCase: true,
                numbers: true,
                symbols: true,
            ),
            [
                Password::MIN_ERROR => $passwordConstraint->minMessage,
                Password::MIXED_CASE_ERROR => $passwordConstraint->mixedCaseMessage,
                Password::SYMBOLS_ERROR => $passwordConstraint->symbolsMessage,
                Password::NUMBERS_ERROR => $passwordConstraint->numbersMessage,
            ],
        ];

        yield [
            'test',
            new Password(
                mixedCase: true,
                numbers: true,
                symbols: true,
            ),
            [
                Password::MIN_ERROR => $passwordConstraint->minMessage,
                Password::MIXED_CASE_ERROR => $passwordConstraint->mixedCaseMessage,
                Password::SYMBOLS_ERROR => $passwordConstraint->symbolsMessage,
                Password::NUMBERS_ERROR => $passwordConstraint->numbersMessage,
            ],
        ];

        yield [
            '0000',
            new Password(
                mixedCase: true,
                numbers: true,
                symbols: true,
            ),
            [
                Password::MIN_ERROR => $passwordConstraint->minMessage,
                Password::MIXED_CASE_ERROR => $passwordConstraint->mixedCaseMessage,
                Password::SYMBOLS_ERROR => $passwordConstraint->symbolsMessage,
            ],
        ];

        yield [
            'azertyuiop000',
            new Password(
                mixedCase: true,
                numbers: true,
                symbols: true,
            ),
            [
                Password::MIXED_CASE_ERROR => $passwordConstraint->mixedCaseMessage,
                Password::SYMBOLS_ERROR => $passwordConstraint->symbolsMessage,
            ],
        ];
    }

    /** @dataProvider validPasswordProvider */
    public function testValidPassword(string $value, Password $contraint): void
    {
        $this->validator->validate($value, $contraint);
        $this->assertNoViolation();
    }

    public function validPasswordProvider(): \Generator
    {
        yield ['azertyuiop', new Password(min: 10)];
        yield ['Azertyuiop000@', new Password(mixedCase: true, numbers: true, symbols: true)];
        yield ['LaSa5KE2udBb3=$$6#?8', new Password(mixedCase: true, numbers: true, symbols: true)];
    }
}
