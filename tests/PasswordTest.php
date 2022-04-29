<?php

declare(strict_types=1);

namespace BaBeuloula\Tests\Constraint;

use BaBeuloula\Constraint\Password;
use BaBeuloula\Constraint\PasswordValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;

/**
 * @author BaBeuloula <info@babeuloula.fr>
 */
class PasswordTest extends TestCase
{
    public function testValidatedByStandardValidator(): void
    {
        $constraint = new Password();

        static::assertSame(PasswordValidator::class, $constraint->validatedBy());
    }

    public function testDefaultValues(): void
    {
        $constraint = new Password();

        static::assertSame(12, $constraint->min);
        static::assertFalse($constraint->mixedCase);
        static::assertFalse($constraint->letters);
        static::assertFalse($constraint->numbers);
        static::assertFalse($constraint->symbols);
    }

    public function testAttributes(): void
    {
        $constraint = new Password();

        $metadata = new ClassMetadata(PasswordDummy::class);
        static::assertTrue((new AnnotationLoader())->loadClassMetadata($metadata));

        /** @var Password $aConstraint */
        [$aConstraint] = $metadata->properties['a']->getConstraints();
        static::assertSame($constraint->min, $aConstraint->min);
        static::assertFalse($aConstraint->mixedCase);
        static::assertFalse($aConstraint->letters);
        static::assertFalse($aConstraint->numbers);
        static::assertFalse($aConstraint->symbols);

        /** @var Password $bConstraint */
        [$bConstraint] = $metadata->properties['b']->getConstraints();
        static::assertSame(8, $bConstraint->min);
        static::assertSame('myMessage', $bConstraint->minMessage);
        static::assertSame(['Default', 'PasswordDummy'], $bConstraint->groups);

        /** @var Password $cConstraint */
        [$cConstraint] = $metadata->properties['c']->getConstraints();
        static::assertTrue($cConstraint->letters);
        static::assertSame('myMessage', $cConstraint->lettersMessage);
        static::assertSame(['my_group'], $cConstraint->groups);
    }
}
