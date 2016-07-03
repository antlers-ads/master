<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates date ranges.
 */
class DateRangeValidator extends ConstraintValidator
{
    /**
     * Validates date range.
     *
     * @param mixed $entity
     * @param Constraint $constraint
     */
    public function validate($entity, Constraint $constraint)
    {
        if ($entity->getStartDate() >= $entity->getEndDate()) {

            /** @noinspection PhpUndefinedMethodInspection */
            /** @noinspection PhpUndefinedFieldInspection */
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
