<?php declare(strict_types=1);

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Result;
use App\Repository\ResultRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ResultCorrectQuestionsFormType extends AbstractType
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

        $correctAnswersIds = $result->correctAnswers()->map(fn(Answer $answer) => $answer->id());
        $correctQuestions = $this->results->findCorrectlyAnsweredQuestionsForResult($result);

        foreach ($correctQuestions as $question) {
            $builder->add('question_' . $question->uuidAsString(), ChoiceType::class, [
                'disabled' => true,
                'multiple' => true,
                'expanded' => true,
                'choices' => $question->answers(),
                'label' => $question->title(),
                'choice_label' => 'title',
                'choice_value' => 'uuidAsString',
                'choice_attr' => fn(Answer $answer) => [
                    'class' => $correctAnswersIds->contains($answer->id()) ? 'tm-correct-answer-checkbox' : '',
                    'checked' => $correctAnswersIds->contains($answer->id()),
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->define('result');
    }
}
