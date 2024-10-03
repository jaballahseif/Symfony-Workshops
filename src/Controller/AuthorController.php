<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('List/')]
    function ListAuthor(){
        $authors = array(
            array('id' => 1, 'picture' => '/img/téléchargement.jfif','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/img/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/img/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            );
        return $this->render('author/list.html.twig',[
            "auth"=>$authors

        ]);

            
    }
    #[Route ('/Detail/{i}',name:'DD')]
    function Detatil($i){
        return $this->render(
            'author/detail.html.twig',
            ['ii'=>$i]
        );
    }
    #[Route ('/Affiche')]
    function Affiche(AuthorRepository $repo){
        $authors=$repo->findAll();

        return $this->render(
            'author/affiche.html.twig',
            ['auth'=>$authors]
        );

    }
    
}
