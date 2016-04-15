<?php

namespace Margo\Controller;

use Margo\Entity\Student;
use Margo\Form\Type\StudentType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;


class FormationController
{

    public function indexAction(Request $request, Application $app)
    {
        // Perform pagination logic.
        $limit = 10;
        $total = $app['repository.formation']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $formations = $app['repository.formation']->findAll($limit, $offset);
        $data = array(
            'formations' => $formations,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('admin_etudiants'),
        );
        return $app['twig']->render('formation.html.twig', $data);
    }

}