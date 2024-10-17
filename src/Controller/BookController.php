<?php

namespace App\Controller;
use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('book/')]
class BookController extends AbstractController
{
    #[Route('book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('ajout', name: 'ajout_book')]

    public function AjoutBook(Request $request,ManagerRegistry $manager){
       $book = new Book;
       $form=$this->createForm(BookType::class,$book)->add('Ajout',SubmitType::class);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
        $em=$manager->getManager();
        $em->persist($book);
        $em->flush();
        //return $this->redirectToRoute('aff');
    }
    return $this->render(
        'book/ajout.html.twig',['form'=>$form->createView()]
    );

        

    }
}
