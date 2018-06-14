<?php

    namespace AppBundle\Controller\Api;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use AppBundle\Entity\Offer;
    use Symfony\Component\Validator\Validator\ValidatorInterface;

    class OffersController extends Controller
    {
        /**
         * @return Response
         * @Route("/api/offers", methods={"GET"})
         */
        public function getAllAction()
        {
            try {
                $repository = $this->getDoctrine()->getRepository(Offer::class);
                $offers = $repository->findAll();
                return $this->json($offers, Response::HTTP_OK);
            } catch (\Exception $e) {
                return $this->json(['status' => 'Fetch error , check API server log'], Response::HTTP_NOT_FOUND);
            }

        }

        /**
         * @param int $offerId
         * @param Request $request
         * @return \Symfony\Component\HttpFoundation\JsonResponse
         * @Route("/api/offers/{offerId}", methods={"GET"})
         */
        public function getByIdAction(int $offerId)
        {
            try {
                $repository = $this->getDoctrine()->getRepository(Offer::class);
                $offer = $repository->find($offerId);
                return $this->json($offer, Response::HTTP_OK);
            } catch (\Exception $e) {
                return $this->json(['status' => 'Fetch error , check API server log'], Response::HTTP_NOT_FOUND);
            }

        }

        /**
         * @param Request $request
         * @Route("/api/offer", methods={"POST"})
         * @return string
         */
        public function addAction(ValidatorInterface $validator, Request $request)
        {

            try {
                $entityManager = $this->getDoctrine()->getManager();

                $offer = new Offer();
                $offer->setTitle($request->request->get('title'));
                $offer->setDescription($request->request->get('description'));
                $offer->setEmail($request->request->get('email'));
                $offer->setImageUrl($request->request->get('image_url'));
                $offer->setCreationDate(new \DateTime("now"));

                $errors = $validator->validate($offer);

                if (count($errors) > 0) {
                    /*
                     * Uses a __toString method on the $errors variable which is a
                     * ConstraintViolationList object. This gives us a nice string
                     * for debugging.
                     */
                    //$errorsString = (string) $errors;

                    return $this->json(['status' => 'Add error , check API server log', 'errors'=>$errors], Response::HTTP_NOT_FOUND);
                }

                $entityManager->persist($offer);
                $entityManager->flush();

                return $this->json(['offerId' => $offer->getId()], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                return $this->json(['status' => 'Add error , check API server log'], Response::HTTP_NOT_FOUND);
            }


        }

        /**
         * @param int $offerId
         * @return string
         * @Route("/api/offers/delete/{offerId}",requirements={"offerId"="\d+"},  methods={"GET"})
         */
        public function deleteAction(int $offerId)
        {

            if (isset($offerId) && is_int($offerId) && intval($offerId) > 0) {
                try {
                    $entityManager = $this->getDoctrine()->getManager();
                    $offer = $entityManager->getRepository(Offer::class)->find($offerId);
                    $entityManager->remove($offer);
                    $entityManager->flush();
                    return $this->json([$offer], Response::HTTP_ACCEPTED);
                } catch (\Exception $e) {
                    return $this->json(['status' => 'Delete error , check API server log'], Response::HTTP_NOT_FOUND);
                }


            }

            return $this->json(['status' => 'The offer ID is missing or is not valid'], Response::HTTP_NOT_FOUND);
        }

        /**
         * @param Request $request
         * @Route("api/update/{offerId}", methods={"PUT", "PATCH", "GET"})
         * @return \Symfony\Component\HttpFoundation\JsonResponse
         */
        public function updateAction(int $offerId, Request $request)
        {
            if (!is_int($offerId)) {
                return $this->json(['status' => 'Fetch error , check API server log'], Response::HTTP_NOT_FOUND);
            }

            try {
                $entityManager = $this->getDoctrine()->getManager();
                $offer = $this->getDoctrine()
                    ->getRepository(Offer::class)
                    ->find($offerId);

                $offer->setTitle($request->request->get('title'));
                $offer->setDescription($request->request->get('description'));
                $offer->setEmail($request->request->get('email'));
                $offer->setImageUrl($request->request->get('image_url'));

                $entityManager->flush();

                return $this->json(['status' => 'Offer updated'], Response::HTTP_OK);

            } catch (\Exception $e) {
                return $this->json(['status' => 'Offer update failed'], Response::HTTP_NOT_FOUND);
            }

        }

    }