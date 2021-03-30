<?php


namespace App\Controller;


use App\Entity\Profile;
use App\Form\ProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    /**
     * @Route("/my-profile", name="profile_myProfile")
     */
    public function myProfile(Request $request, EntityManagerInterface $em): Response {

        $profile = new Profile();

        $profileForm = $this->createForm(ProfileFormType::class, $profile);

        // soumission de la requete
        $profileForm->handleRequest($request);

        // on traite la reception de la requete :
        if ( $profileForm->isSubmitted() && $profileForm->isValid() ) {
            $profile->setUser($this->getUser());
            $profile->setDateCreated(new \DateTime());

            $em->persist($profile);
            $em->flush();

            return $this->redirectToRoute('profile_myPhoto');
        }

        return $this->render('profile/myProfile.html.twig', [
            "profileForm" => $profileForm ->createView()
        ]);
    }

    /**
     * @Route("/my-profile/photo", name="profile_myPhoto")
     */
    public function myPhoto(Request $request, EntityManagerInterface $em): Response {

        return $this->render('', [

        ]);
    }



}