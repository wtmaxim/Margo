<?php

namespace Margo\Controller;

use Margo\Entity;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;


class StudentController
{

    public function indexAction(Request $request, Application $app)
    {
        // Perform pagination logic.
        $limit = 10;
        $total = $app['repository.etudiant']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $etudiants = $app['repository.etudiant']->findAll($limit, $offset);
        $data = array(
            'etudiants' => $etudiants,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('admin_etudiants'),
        );
        return $app['twig']->render('student.html.twig', $data);
    }

    public function addAction(Request $request, Application $app)
    {
        $etudiant = new Student();
        $form = $app['form.factory']->create(new StudentType(), $artist);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.artist']->save($artist);
                $message = 'The artist ' . $artist->getName() . ' has been saved.';
                $app['session']->getFlashBag()->add('success', $message);
                // Redirect to the edit page.
                $redirect = $app['url_generator']->generate('admin_artist_edit', array('artist' => $artist->getId()));
                return $app->redirect($redirect);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Add new artist',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function deleteAction(Request $request, Application $app)
    {
        $etudiant = $request->attributes->get('etudiant');
        if (!$etudiant) {
            $app->abort(404, 'The requested student was not found.');
        }
        $app['repository.etudiant']->delete($etudiant);
        return $app->redirect($app['url_generator']->generate('admin_etudiants'));
    }

}