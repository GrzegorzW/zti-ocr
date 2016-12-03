<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Challenge;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueQuestionAnswersValidator extends ConstraintValidator
{
    private $collectionValues = [];

    public function validate($collection, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueQuestionAnswers) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\UniqueQuestionAnswers');
        }

        if (!$collection instanceof ArrayCollection) {
            return;
        }

        /** @var Form $form */
        $form = $this->context->getRoot();
        $data = $form->getData();

        if (!$data instanceof Challenge) {
            throw new UnexpectedTypeException($data, Challenge::class);
        }

        $correctAnswer = $data->getAnswers();
        if ($correctAnswer) {
            $this->collectionValues[] = $correctAnswer;
        }

        foreach ($collection as $item) {
            if (!$item instanceof Answer) {
                throw new UnexpectedTypeException($item, Answer::class);
            }

            $content = $item->getContent();
            if ($this->isUnique($content)) {
                $this->collectionValues[] = $content;
            } else {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
                break;
            }
        }
    }

    private function isUnique($value)
    {
        return in_array($value, $this->collectionValues, true) === false;
    }
}
