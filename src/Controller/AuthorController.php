<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
    #[Route ('/Affiche',name:'aff')]
    function Affiche(AuthorRepository $repo){
        $authors=$repo->findAll();

        return $this->render(
            'author/affiche.html.twig',
            ['auth'=>$authors]
        );

    }
    #[Route ('Ajout/',name:'ajout')]
    function Ajout(Request $request,ManagerRegistry $manager){
        $author = new Author;
        $form=$this->createForm(AuthorType::class,$author)->add('Ajout',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$manager->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('aff');
        }

        return $this->render(
            'author/ajout.html.twig',['form'=>$form->createView()]
        );

    }
    #[Route('/Detail2/{i2}', name: 'DD2')]
    public function Detail2($i2, AuthorRepository $repo): Response
    {
        $author = $repo->find($i2);

        return $this->render('author/detail2.html.twig', [
            'ii2' => $author,
        ]);
    }

    #[Route('/remove/{i3}', name: 'DD3')]
    public function Remove($i3,ManagerRegistry $manager,AuthorRepository $repo): Response
    {
        $em=$manager->getManager();

        $author = $repo->find($i3);
        if (!empty($author) ) {
            $em->Remove($author);
            $em->flush();
            return $this->redirectToRoute('aff');

        }
    }


    
    #[Route ('Uodate/{j}',name:'DD4')]
    function Update($j,Request $request,ManagerRegistry $manager,AuthorRepository $repo){
        $author = $repo->find($j);

        $form=$this->createForm(AuthorType::class,$author)->add('update',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$manager->getManager();
        
            $em->flush();
            return $this->redirectToRoute('aff');
        }

        return $this->render(
            'author/ajout.html.twig',['form'=>$form->createView()]
        );

    }

    #[Route ('/Mail',name:'mail')]
    function Mail(AuthorRepository $repo){
        $authors=$repo->TrieMail();

        return $this->render(
            'author/affiche.html.twig',
            ['auth'=>$authors]
        );

    }


}
    
