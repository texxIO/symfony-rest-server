<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $availableRequests = ['availableRequests' => [
            'api/offers',
            'api/offers/{ID}',
            'api/offer'
        ]
        ];
        return $this->json($availableRequests, 200);
    }
}
