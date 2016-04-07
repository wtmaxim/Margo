<?php

namespace Margo\Controller;

use Margo\Entity;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;


class TeacherController
{

    public function indexAction(Request $request, Application $app)
    {
        // Perform pagination logic.
        $limit = 10;
        $total = $app['repository.Teacher']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $teachers = $app['repository.Teacher']->findAll($limit, $offset);
        $data = array(
            'teachers' => $teachers,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('admin_profs'),
        );
        return $app['twig']->render('teacher.html.twig', $data);
    }

}