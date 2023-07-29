<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\News;
use App\Repository\LikeRepository;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/news')]
class NewsController extends AbstractController
{
    #[Route('/', name: 'app_news_index', methods: ['GET'])]
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('news/index.html.twig', [
            'news' => $newsRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_news_show', methods: ['GET'])]
    public function show(News $news): Response
    {
        return $this->render('news/show.html.twig', [
            'news' => $news,
        ]);
    }

    #[Route('/like/{id}', name: 'app_news_like', methods: ['POST'])]
    public function like(News $news, Security $security, LikeRepository $likeRepository): Response
    {
        $like = new Like();
        $like
            ->setNews($news)
            ->setUser($security->getUser());
        $likeRepository->save($like, true);
        return $this->redirectToRoute('app_news_index');
    }
}
