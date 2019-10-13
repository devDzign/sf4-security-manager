<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/{id}", name="admin_article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ( $this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token')) ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

}
