<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Reaction;
use App\Entity\User;
use App\Repository\ProfileRepository;
use App\Repository\ReactionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ReactionController extends AbstractController
{
    /**
     * @Route("/reaction", name="reaction_addReaction", methods={"POST"})
     */
    public function addReaction(Request $request, ReactionRepository $reactionRepository, UserRepository $userRepository, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $jsonData = $request->getContent();
        $data = intval(json_decode($jsonData)->id);

        // on créer un objet Reaction depuis le Json reçu :
        ///** @var Reaction $reaction */
        //$reaction = $serializer->deserialize($data, Reaction::class, 'json');
        $reaction = new Reaction();
        // on hydrate notre objet Reaction :
        /** @var Profile $profileUserSendTo */
        $profileUserSendTo = $this->getUser()->getProfile();
        $reaction->setSendTo($profileUserSendTo);
        /** @var User $userLiked */
        $userLiked = $userRepository->find($data);
        $reaction->setUserLiked($userLiked->getProfile());
        $reaction->setDateCreated(new \DateTime());
        $reaction->setReciprocal(null);

        dd($reaction);

        //return new Response([
        //    'status' => 201,
        //    'message' => 'Like send successfully !',
        //    'data' => $reaction
        //], 201);

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
