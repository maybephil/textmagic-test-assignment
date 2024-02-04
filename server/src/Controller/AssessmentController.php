<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Assessment;
use App\Form\AssessmentQuestionsFormType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AssessmentController extends AbstractController
{
    #[Route(path: '/{uuidBase32}', name: 'app_assessment_index', methods: [ 'GET' ])]
    public function indexAction(
        #[MapEntity(expr: 'repository.findOneByBase32Uuid(uuidBase32)')]
        Assessment $assessment,
    ): Response
    {
        $form = $this->createForm(AssessmentQuestionsFormType::class, null, [
            'assessment_id' => $assessment->idAsInt(),
        ]);

        return $this->render('assessment.html.twig', [
            'assessment' => $assessment,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{uuidBase32}', methods: [ 'POST' ])]
    public function postAction(
        #[MapEntity(expr: 'repository.findOneByBase32Uuid(uuidBase32)')]
        Assessment $assessment,
        Request $request,
    ): Response
    {
        $form = $this->createForm(AssessmentQuestionsFormType::class, null, [
            'assessment_id' => $assessment->idAsInt(),
        ]);

        $form->handleRequest($request);

        if (!$form->isValid()) {
            dd($form->getErrors()->count());
        }

        dd($form->getData());
    }
}