<?php

namespace Margo\Controller;

use Margo\Entity\Teacher;
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
            'here' => $app['url_generator']->generate('admin_teacher'),
        );
        return $app['twig']->render('teacher.html.twig', $data);
    }
    public function addAction(Request $request, Application $app)
    {
        $teacher = new Teacher();
        $form = $app['form.factory']->create(new StudentType(), $teacher);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.Teacher']->save($teacher);
                $message = 'The teacher' . $teacher->getTeacherName() . ' has been saved.';
                $app['session']->getFlashBag()->add('success', $message);
                // Redirect to the edit page.
                $redirect = $app['url_generator']->generate('admin_artist_edit', array('artist' => $teacher->getId()));
                return $app->redirect($redirect);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Add new teacher',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function deleteAction(Request $request, Application $app)
    {
        $teacher = $request->attributes->get('teacher');
        var_dump($teacher);

        if (!$teacher) {
            $app->abort(404, 'The requested teacher was not found.');
        }
        $app['repository.Teacher']->delete($teacher);
        return $app->redirect($app['url_generator']->generate('admin_teacher'));

    }
}