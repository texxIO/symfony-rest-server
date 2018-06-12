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
     * @Route("/api/offers/{offerId}", methods={"GET"})
     */
    public function getByIdAction( int $offerId, Request $request)
    {
        if (  $offerId > 0 )
        {
            $repository = $this->getDoctrine()->getRepository(Offer::class);
            $offer = $repository->find($offerId);
            return $this->json($offer, 200);
        }
        return $this->json(['status'=>'Fetch error , check API server log'], 404);
    }

    /**
     * @param Request $request
     * @Route("/api/offer", methods={"POST"})
     * @return string
     */
    public function addAction( Request $request )
    {
        /*
        $offerData['title'] = $request->request->get('title');
        $offerData['description'] = $request->request->get('description');
        $offerData['email'] = $request->request->get('email');
        $offerData['image_url'] = $request->request->get('image_url');
        $offerData['creation_date'] = new \DateTime("now");
        */

        try
        {
            $entityManager = $this->getDoctrine()->getManager();

            $offer = new Offer();
            $offer->setTitle($request->request->get('title'));
            $offer->setDescription($request->request->get('description'));
            $offer->setEmail($request->request->get('email'));
            $offer->setImageUrl($request->request->get('image_url'));
            $offer->setCreationDate(new \DateTime("now"));

            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->json(['offerId'=>$offer->getId()], 200);
        }
        catch ( \Exception $e )
        {
            return $this->json(['status'=>'Add error , check API server log'], 404);
        }


    }

    /**
     * @param Request $request
     * @Route("/api/offers/delete/{offerId}",requirements={"offerId"="\d+"},  methods={"GET"})
     * @return string
     */
    public function deleteAction( int $offerId )
    {

        if ( isset($offerId) && is_int($offerId) && intval($offerId) > 0 ) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $offer = $entityManager->getRepository(Offer::class)->find($offerId);
                $entityManager->remove($offer);
                $entityManager->flush();
                return $this->json([$offer], 200);
            }
            catch ( \Exception $e )
            {
                return $this->json(['status'=>'Delete error , check API server log'], 404);
            }


        }

        return $this->json(['status'=>'The offer ID is missing or is not valid'], 404);
    }

    /**
     * @param Request $request
     * @Route("api/update/{offerId}", methods={"PUT", "PATCH", "GET"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction( int $offerId, Request $request )
    {
        if ( !is_int($offerId) )
        {
            return $this->json(['status'=>'Fetch error , check API server log'], 404);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($offerId);

        $offer->setTitle($request->request->get('title'));
        $offer->setDescription($request->request->get('description'));
        $offer->setEmail($request->request->get('email'));
        $offer->setImageUrl($request->request->get('image_url'));

        $entityManager->flush();

        return $this->json(['status'=>'Offer Updated'], 200);

    }


}