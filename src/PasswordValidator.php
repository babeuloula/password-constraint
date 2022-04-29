<?php

declare(strict_types=1);

namespace BaBeuloula\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author BaBeuloula <info@babeuloula.fr>
 */
class PasswordValidator extends ConstraintValidator
{
    /**
     * @param ?string $value
     * @param Password|Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (false === $constraint instanceof Password) {
            throw new UnexpectedTypeException($constraint, Password::class);
        }

        $value = (string) $value;

        if (mb_strlen($value) < $constraint->min) {
            $this->context
                ->buildViolation($constraint->minMessage)
                ->setParameter('{{ min }}', (string) $constraint->min)
                ->setInvalidValue($value)
                ->setCode(Password::MIN_ERROR)
                ->addViolation()
            ;
        }

        if (true === $constraint->mixedCase && 1 !== preg_match('/(\p{Ll}+.*\p{Lu})|(\p{Lu}+.*\p{Ll})/u', $value)) {
            $this->context
                ->buildViolation($constraint->mixedCaseMessage)
                ->setInvalidValue($value)
                ->setCode(Password::MIXED_CASE_ERROR)
                ->addViolation()
            ;
        }

        if (true === $constraint->letters && 1 !== preg_match('/\pL/u', $value)) {
            $this->context
                ->buildViolation($constraint->lettersMessage)
                ->setInvalidValue($value)
                ->setCode(Password::LETTERS_ERROR)
                ->addViolation()
            ;
        }

        if (true === $constraint->symbols && 1 !== preg_match('/\p{Z}|\p{S}|\p{P}/u', $value)) {
            $this->context
                ->buildViolation($constraint->symbolsMessage)
                ->setInvalidValue($value)
                ->setCode(Password::SYMBOLS_ERROR)
                ->addViolation()
            ;
        }

        if (true === $constraint->numbers && 1 !== preg_match('/\pN/u', $value)) {
            $this->context
                ->buildViolation($constraint->numbersMessage)
                ->setInvalidValue($value)
                ->setCode(Password::NUMBERS_ERROR)
                ->addViolation()
            ;
        }
    }
}
