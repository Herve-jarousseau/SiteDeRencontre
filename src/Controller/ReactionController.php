<?php

namespace App\Controller;

use App\Entity\Reaction;
use App\Repository\ReactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ReactionController extends AbstractController
{
    /**
     * @Route("/reaction", name="reaction_addReaction", methods={"POST"})
     */
    public function addReaction(Request $request, ReactionRepository $reactionRepository, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $data = $request->getContent();
        /** @var Reaction $reaction */
        $reaction = $serializer->deserialize($data, Reaction::class, 'json');
        //$reaction->setSendTo($this->getUser());
        $reaction->setDateCreated(new \DateTime());

        dd($reaction);
        // TODO
        return new Response([
            'status' => 201,
            'message' => 'Like send successfully !',
            'data' => $reaction
        ], 201);

    }

    /**
     * @Route("/reaction", name="reaction_getReaction", methods={"GET"})
     */
    public function getReaction(): Response
    {
        return $this->render('reaction/index.html.twig', [
            'controller_name' => 'ReactionController',
        ]);
    }
}
