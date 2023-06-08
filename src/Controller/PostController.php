<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\EditPostFormType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/new', name: 'app_post_new')]
    public function new(
        Request $request,
        PostRepository $postRepository
    ) {
        $form = $this->createForm(EditPostFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
           $post = $form->getData();
           $post->setCreatedAt(new \DateTimeImmutable());

           $postRepository->save($post, true);

           return $this->redirectToRoute('app_post');
        }

        return $this->render('post/new.html.twig', [
            'editPostForm' => $form->createView()
        ]);
    }
}
