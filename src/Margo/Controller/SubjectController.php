<?php

namespace Margo\Controller;

use Margo\Entity\Subject;
use Margo\Form\Type\SubjectType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;


class SubjectController
{

    public function indexAction(Request $request, Application $app)
    {
        // Perform pagination logic.
        $limit = 10;
        $total = $app['repository.subject']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $subjects = $app['repository.subject']->findAll($limit, $offset);
        $data = array(
            'subjects' => $subjects,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('subject'),
        );
        return $app['twig']->render('subject.html.twig', $data);
    }
}