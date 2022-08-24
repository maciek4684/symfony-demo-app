<?php

namespace App\Controller;

use App\Entity\CodeLanguage;
use App\Entity\AppUser;
use App\Repository\CodeLanguageRepository;
use App\Repository\AppUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\ApiToken;
use App\Repository\ApiTokenRepository;

//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DefaultController extends AbstractController
{
//    private UserPasswordHasherInterface $hasher;

    public function __construct(
//        UserPasswordHasherInterface $hasher
    )
    {
//        $this->hasher = $hasher;
    }

    #[Route('/', name: 'default')]
    public function index(
        Request                $request,
        ManagerRegistry        $doctrine,
//        ApiTokenRepository     $repository,
//        CodeLanguageRepository $codeLanguageRepository,
//        AppUserRepository      $userRepository
    ) : Response
    {

        $entityManager = $doctrine->getManager();

//        $languages = $codeLanguageRepository->find(1);
//        var_dump($languages->getShortName());
        //        $entityManager->persist($token);
//        $entityManager->flush();

//        $tokens = $repository->findAll();

//        $apiToken = "3672df68f5de26207a815122cd1bbcfe62204ae32237f76312da3d8ed29cb266";
//        $u = $userRepository->findOneByApiToken($apiToken);
//
//        $use = function() use ($apiToken) {
//           return $this->repo->findOneByApiToken($apiToken);
//        };
//
//
//        $users = $userRepository->findBy(["email" => "admin@example.com"]);
//        $tokens = $repository->findAll();
//        dd($use);


        return $this->render('default/default.html.twig');
    }

    #[Route('/api/login', name: 'api_login')]
    public function apiLogin(Request $request)
    {
        return new Response("ok", 201);
    }
    #[Route('/api/data', name: 'api_data_1')]
    public function apiData1(Request $request)
    {
        return new Response("ok ok", 201);
    }

    #[Route('/data', name: 'api_data')]
    public function apiData(Request $request)
    {
        return new Response("ok", 201);
    }
}
