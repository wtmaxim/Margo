<?php

namespace Margo\Controller;

use Margo\Entity\Category;
use Margo\Form\Type\CategoryType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class CategoryController
{

    public function indexAction(Request $request, Application $app)
    {
        // Perform pagination logic.
        $limit = 100;
        $total = $app['repository.category']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $classes = $app['repository.category']->findAll($limit, $offset);
        $data = array(
            'classes' => $classes,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('admin_categories'),
        );
        return $app['twig']->render('category.html.twig', $data);

    }

}