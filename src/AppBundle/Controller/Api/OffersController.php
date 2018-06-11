<?php
namespace AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Repository\OfferRepository;
use AppBundle\Entity\Offer;

class OffersController extends Controller
{
    /**
     * @param Request $request
     * @Route("/api/offers", methods={"GET"})
     * @return Response
     */
    public function getAllAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Offer::class);
        $offers = $repository->findAll();
        return $this->json($offers, 200);
    }

    /**
     * @param int $offerId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/api/offers/{offerId}")
     */
    public function getByIdAction( int $offerId, Request $request)
    {
        if (  $offerId > 0 )
        {
            $repository = $this->getDoctrine()->getRepository(Offer::class);
            $offer = $repository->find($offerId);
            return $this->json($offer, 200);
        }
        return $this->json([], 404);
    }

    /**
     * @param Request $request
     * @Route("/api/offer")
     * @return string
     */
    public function addAction( Request $request )
    {
        $data = $request->post();
        return json_encode($data);
    }


}