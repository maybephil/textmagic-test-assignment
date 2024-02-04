<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\AssessmentRepository;
use App\Repository\ResultRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    public function __construct(
        private readonly AssessmentRepository $assessments,
        private readonly ResultRepository $results,
    )
    {
    }

    #[Route('/', name: 'app_index', methods: [ 'GET' ])]
    public function indexAction(): Response
    {
        return $this->render('index.html.twig', [
            'assessments' => $this->assessments->findAll(),
            'results' => $this->results->findAll(),
        ]);
    }
}
