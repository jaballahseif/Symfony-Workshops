<?php

namespace App\Controller;

use App\Entity\Author;
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
use Symfony\Component\Validator\Constraints\Length;

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
        $nb=$repo->CountNbBooks();

        return $this->render(
            'book/affiche.html.twig',
            ['book'=>$books,'nb'=>$nb]
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
    #[Route('deleteauth', name: 'delete0')]
    public function Removebook0(ManagerRegistry $manager,AuthorRepository $repo): Response
    {
        $em=$manager->getManager();

        $auths = $repo->findAll();
        foreach ($auths as $auth){
            if ($auth->getNbbooks()==0) {
                $em->remove($auth); 

            }
        }
        $em->flush();
    return $this->redirectToRoute('aff');
    }
    #[Route('details/{b}', name: 'details')]
    public function Detail($b,BookRepository $repo): Response
    {

        $book = $repo->find($b);

    return $this->render('book/detail.html.twig', [
        'bb' => $book,
    ]);
    }

    #[Route('search', name: 'search_ref')]
    function SearchRef(BookRepository $repo,Request $request){
        $ref=$request->get('ref');
        
        $book=$repo->findByRef($ref);
        return $this->render(
            'book/affiche.html.twig',
            ['book'=>$book]  
        );
    }
    #[Route('date', name: 'search_date')]
    function SearchDate(BookRepository $repo,Request $request){
        $min=$request->get('min');
        $max=$request->get('max');
        $book=$repo->FindDate($min,$max);
        return $this->render(
            'book/date.html.twig',
            ['b'=>$book]  
        );
    }

    
    #[Route ('/Authbybook',name:'bookauth')]
    function Book(BookRepository $repo,Request $request){
        $name=$request->get('name');

        $book=$repo->AuthorByBook($name);

        return $this->render(
            'book/affiche.html.twig',
            ['book'=>$book]
        );

    }

}
