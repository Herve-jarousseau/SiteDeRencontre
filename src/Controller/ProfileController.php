<?php


namespace App\Controller;


use App\Entity\Picture;
use App\Entity\Preference;
use App\Entity\Profile;
use App\Form\PreferenceFormType;
use App\Form\ProfileFormType;
use App\Form\ProfilePictureFormType;
use App\Repository\PreferenceRepository;
use App\Repository\ProfileRepository;
use claviska\SimpleImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\ByteString;

class ProfileController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    /**
     * @Route("/profile", name="profile_profile")
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

            return $this->redirectToRoute('profile_Photo');
        }

        return $this->render('profile/myProfile.html.twig', [
            "profileForm" => $profileForm->createView()
        ]);
    }

    /**
     * @Route("/profile/photo", name="profile_Photo")
     */
    public function myPhoto(Request $request, EntityManagerInterface $em): Response {

        $picture = new Picture();
        $pictureForm = $this->createForm(ProfilePictureFormType::class, $picture);

        // soumission de la requete
        $pictureForm->handleRequest($request);
        if ( $pictureForm->isSubmitted() && $pictureForm->isValid() ) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $pictureForm->get('fileName')->getData();
            // on génere un nom de fichier sécu
            $newFileName = ByteString::fromRandom(30) . '.' . $uploadedFile->guessExtension();
            // on déplace le fichier dans le répertoire public avant sa destruction
            try {
                $uploadedFile->move($this->getParameter('upload_dir'), $newFileName);
            } catch (\Exception $e) {
                dd($e->getMessage());
                // TODO gestion d'exception !
            }
            // on redimensionne l'image :
            $simpleImage = new SimpleImage();
            $simpleImage->fromFile($this->getParameter('upload_dir') . "/$newFileName")
                ->thumbnail(300,300)
                ->toFile($this->getParameter('upload_dir') . "/$newFileName");

            // on hydrate notre objet
            $picture->setFileName($newFileName);
            $picture->setDateCreated(new \DateTime());
            $picture->setProfile($this->getUser()->getProfile());
            //$this->getUser()->getProfile()->setPicture($picture);

            // on requête
            $em->persist($picture);
            $em->flush();

            return $this->redirectToRoute('main_home');
        }

        return $this->render('profile/myPicture.html.twig', [
            "pictureForm" => $pictureForm->createView(),
        ]);
    }

    /**
     * @Route("/profile/info/{id}", name="profile_info", requirements={"id"="\d+"})
     */
    public function informations(Request $request, ProfileRepository $profileRepository, EntityManagerInterface $em, $id): Response {

        $userProfile = $profileRepository->findOneBy([
            'user' => $id
        ]);

        $preference = new Preference();
        $preferenceForm = $this->createForm(PreferenceFormType::class, $preference);

        // soumission de la requete
        $preferenceForm->handleRequest($request);
        if ( $preferenceForm->isSubmitted() && $preferenceForm->isValid() ) {
            $preference->setProfile($userProfile);

            $em->persist($preference);
            $em->flush();
        }

        $preferences = $userProfile->getPreferences();

        return $this->render('/profile/infoProfile.html.twig', [
            'profil' => $userProfile,
            'preferences' => $preferences,
            'preferenceForm' => $preferenceForm->createView(),
        ]);

    }

    /**
     * @Route("/preference/remove/{id}", name="profile_removePreference", requirements={"id"="\d+"})
     */
    public function deletePreference(Request $request, PreferenceRepository $preferenceRepository, EntityManagerInterface $em, $id): Response {

        $preferenceToRemove = $preferenceRepository->find($id);
        $idUserOfPreference = $preferenceToRemove->getProfile()->getUser()->getId();
        $idUserOfSession = $this->getUser()->getId();

        if ( $idUserOfPreference == $idUserOfSession && $preferenceToRemove ) {
            $em->remove($preferenceToRemove);
            $em->flush();
        }

        return $this->redirectToRoute('profile_info', ['id' => $idUserOfSession]);
    }

}