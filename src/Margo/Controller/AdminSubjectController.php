<?php

namespace Margo\Controller;

use Margo\Entity\Subject;
use Margo\Form\Type\SubjectType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;


class AdminSubjectController
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
            'here' => $app['url_generator']->generate('admin_subjects'),
        );
        return $app['twig']->render('adminSubject.html.twig', $data);
    }

    public function addAction(Request $request, Application $app)
    {

        $subject = new Subject();
        $form = $app['form.factory']->create(new SubjectType(), $subject);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $name = $subject->getCategory();
            $category = $app['repository.category']->selectOneByNameCateg($name);
            if ($form->isValid() && !empty($category)) {
                $app['repository.subject']->save($subject);
                $message = 'Le cours ' . $subject->getNameSubject() . ' à été ajouté.';
                $app['session']->getFlashBag()->add('success', $message);
                // Redirect to the edit page.
                $redirect = $app['url_generator']->generate('admin_subject_add', array('subject' => $subject->getIdSubject()));
                return $app->redirect($redirect);
            } else {
                $message = 'La classe inscrite n\'existe pas.';
                $app['session']->getFlashBag()->add('error', $message);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Ajout d\'un cours',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function editAction(Request $request, Application $app)
    {
        $subject = $request->attributes->get('matiere');
        if (!$subject) {
            $app->abort(404, 'La requête cours n\'a pas été trouvé.');
        }
        $form = $app['form.factory']->create(new SubjectType(), $subject);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.subject']->save($subject);
                $message = 'Le cours à été modifié !.';
                $app['session']->getFlashBag()->add('success', $message);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Edition d\'un cours',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function deleteAction(Request $request, Application $app)
    {
        $subject = $request->attributes->get('matiere');
        if (!$subject) {
            $app->abort(404, 'The requested subject was not found.');
        }

        $profs = $app['repository.prof']->selectOneByNameSubject($subject->getNameSubject());
        if (!empty($profs)) {
            $message = 'Impossible de supprimer : un ou plusieurs professeurs sont inscrits à ce cours';
            $app['session']->getFlashBag()->add('error', $message);
        } else {
            $app['repository.subject']->delete($subject);
        }

        return $app->redirect($app['url_generator']->generate('admin_subjects'));

    }

}