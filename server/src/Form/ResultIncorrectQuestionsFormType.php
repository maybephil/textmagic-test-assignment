<?php declare(strict_types=1);

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Result;
use App\Repository\ResultRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ResultIncorrectQuestionsFormType extends AbstractType
{
    public function __construct(
        private readonly ResultRepository $results,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Result $result */
        $result = $options['result'];

        $incorrectAnswerIds = $result->incorrectAnswers()->map(fn(Answer $answer) => $answer->id());
        $incorrectQuestions = $this->results->findIncorrectlyAnsweredQuestionsForResult($result);

        foreach ($incorrectQuestions as $question) {
            $builder->add('question_' . $question->uuidAsString(), ChoiceType::class, [
                'disabled' => true,
                'multiple' => true,
                'expanded' => true,
                'choices' => $question->answers(),
                'label' => $question->description(),
                'choice_label' => 'description',
                'choice_value' => 'uuidAsString',
                'choice_attr' => fn(Answer $answer) => [
                    'class' => $incorrectAnswerIds->contains($answer->id()) ? 'tm-incorrect-answer-checkbox' : '',
                    'checked' => $incorrectAnswerIds->contains($answer->id()),
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->define('result');
    }
}
