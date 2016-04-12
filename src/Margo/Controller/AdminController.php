<?php

namespace Margo\Controller;

use Margo\Entity\Subject;
use Margo\Form\Type\SubjectType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;


class AdminController
{

    public function indexAction(Request $request, Application $app)
    {
        $data = array(
            'here' => $app['url_generator']->generate('admin'),
        );
        return $app['twig']->render('admin.html.twig', $data);
    }
}