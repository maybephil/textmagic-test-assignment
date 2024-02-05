<?php declare(strict_types=1);

namespace App\Form;

use App\Repository\QuestionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

final class AssessmentQuestionsFormType extends AbstractType
{
    public function __construct(
        private readonly QuestionRepository $questions,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var int $assessmentId */
        $assessmentId = $options['assessment_id'];

        $questions = $this->questions->findAllWithAnswersByAssessmentId($assessmentId);

        foreach ($questions as $question) {
            $builder->add($question->uuidAsString(), ChoiceType::class, [
                'required' => true,
                'expanded' => true,
                'multiple' => true,
                'choices' => $question->answers(),
                'label' => $question->title(),
                'choice_label' => 'title',
                'choice_value' => 'uuidAsString',
                'constraints' => [
                    new NotBlank(),
                    new Choice(
                        choices: $question->answers()->toArray(),
                        multiple: true,
                    ),
                ],
            ]);
        }

        $builder->add('submit', SubmitType::class, [
            'label' => 'Submit',
            'attr' => [
                'class' => 'btn-success mt-3',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->define('assessment_id');
    }
}
