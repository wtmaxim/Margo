<?php

namespace Margo\Controller;

use Margo\Entity\Teacher;
use Margo\Form\Type\TeacherType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class TeacherController
{

    public function indexAction(Request $request, Application $app)
    {
        // Perform pagination logic.
        $limit = 10;
        $total = $app['repository.prof']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $profs = $app['repository.prof']->findAll($limit, $offset);
        $data = array(
            'profs' => $profs,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('admin_teachers'),
        );
        return $app['twig']->render('teacher.html.twig', $data);

    }

}