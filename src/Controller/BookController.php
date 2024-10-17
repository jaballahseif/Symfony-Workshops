<?php

namespace App\Controller;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
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
    public function AjoutBook(Request $request,ManagerRegistry $manager,AuthorRepository $auth){
    
       $book = new Book;
       $form=$this->createForm(BookType::class,$book)->add('Ajout',SubmitType::class);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {

        $em=$manager->getManager();
        $nb = $book->getIdAuthor()->getNbbooks()+1;
        $book->getIdAuthor()->setNbbooks($nb);
        $em->persist($book);
        $em->flush();

        



        return $this->redirectToRoute('affbook');

    }
    return $this->render(
        'book/ajout.html.twig',[
            'form'=>$form->createView()]
    );
    }

    #[Route('affiche',name:'affbook')]
    function Affiche(BookRepository $repo){
        $books=$repo->findAll();

        return $this->render(
            'book/affiche.html.twig',
            ['book'=>$books]
        );

    }
    #[Route('update/{b}', name: 'update')]
    public function UpdateBook(Request $request,ManagerRegistry $manager,BookRepository $repo,$b){
        $book = $repo->find($b);
       $form=$this->createForm(BookType::class,$book)->add('update',SubmitType::class);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
        $em=$manager->getManager();
        $em->flush();
        return $this->redirectToRoute('affbook');
    }
    return $this->render(
        'book/ajout.html.twig',['form'=>$form->createView()]
    );
    }
    #[Route('delete/{b}', name: 'delete')]
    public function Removebook($b,ManagerRegistry $manager,BookRepository $repo): Response
    {
        $em=$manager->getManager();

        $book = $repo->find($b);
        if (!empty($book) ) {
            $em->Remove($book);
            $em->flush();
            return $this->redirectToRoute('affbook');

        }
    }
}
