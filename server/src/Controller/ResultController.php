<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Result;
use App\Form\ResultCorrectQuestionsFormType;
use App\Form\ResultIncorrectQuestionsFormType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

final class ResultController extends AbstractController
{
    #[Route('/result/{uuid}', name: 'app_result_index', methods: [ 'GET' ])]
    public function indexAction(
        #[MapEntity(expr: 'repository.findOneByUuidAsString(uuid)')]
        Result $result,
    )
    {
        $correctQuestionsForm = $this->createForm(ResultCorrectQuestionsFormType::class, null, [
            'result' => $result,
        ]);

        $incorrectQuestionsForm = $this->createForm(ResultIncorrectQuestionsFormType::class, null, [
            'result' => $result,
        ]);

        $hasCorrectQuestions = $result->correctAnswers()->count() > 0;
        $hasIncorrectQuestions = $result->incorrectAnswers()->count() > 0;

        return $this->render('result.html.twig', [
            'result' => $result,
            'has_correct_questions' => $hasCorrectQuestions,
            'correct_questions_form' => $correctQuestionsForm->createView(),
            'has_incorrect_questions' => $hasIncorrectQuestions,
            'incorrect_questions_form' => $incorrectQuestionsForm->createView(),
        ]);
    }
}
