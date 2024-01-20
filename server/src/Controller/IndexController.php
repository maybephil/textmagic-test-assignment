<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\AssessmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    public function __construct(
        private readonly AssessmentRepository $assessments,
    ) {
    }

    #[Route('/', methods: ['GET'])]
    public function indexAction(): Response
    {
        $assessments = $this->assessments->findAll();

        return $this->render('index.html.twig', [
            'assessments' => $assessments,
        ]);
    }
}
