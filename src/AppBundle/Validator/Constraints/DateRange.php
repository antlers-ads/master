<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint for date ranges.
 *
 * @Annotation
 */
class DateRange extends Constraint
{
    /** @var string */
    public $message = 'Date range is incorrect.';

    /**
     * Defines this constraint as a class constraint.
     *
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
