<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Assessment;
use App\Form\AssessmentQuestionsFormType;
use App\Service\ResultSubmissionService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AssessmentController extends AbstractController
{
    public function __construct(
        private readonly ResultSubmissionService $submissionService,
    )
    {
    }

    #[Route(path: '/{uuid}', name: 'app_assessment_index', methods: [ 'GET' ])]
    public function indexAction(
        #[MapEntity(expr: 'repository.findOneByUuidAsString(uuid)')]
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

    #[Route(path: '/{uuid}', methods: [ 'POST' ])]
    public function postAction(
        #[MapEntity(expr: 'repository.findOneByUuidAsString(uuid)')]
        Assessment $assessment,
        Request $request,
    ): Response
    {
        $form = $this->createForm(AssessmentQuestionsFormType::class, null, [
            'assessment_id' => $assessment->idAsInt(),
        ]);

        $form->handleRequest($request);

        $this->submissionService->submit($assessment, $form->getData());

        return $this->redirectToRoute('app_index');
    }
}
