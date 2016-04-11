<?php

namespace Margo\Controller;

use Margo\Entity\Teacher;
use Margo\Form\Type\TeacherType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class AdminTeacherController
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
        return $app['twig']->render('adminTeacher.html.twig', $data);

    }

    public function addAction(Request $request, Application $app)
    {
        $teacher = new Teacher();
        $form = $app['form.factory']->create(new TeacherType(), $teacher);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.prof']->save($teacher);
                $message = 'Le prof ' . $teacher->getName() . ' à été ajouté.';
                $app['session']->getFlashBag()->add('success', $message);
                // Redirect to the edit page.
                $redirect = $app['url_generator']->generate('admin_teacher_add', array('prof' => $teacher->getTeacherId()));
                return $app->redirect($redirect);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Ajout d\'un prof',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function editAction(Request $request, Application $app)
    {
        $prof = $request->attributes->get('prof');
        if (!$prof) {
            $app->abort(404, 'La requête prof n\a pas été trouvé.');
        }
        $form = $app['form.factory']->create(new TeacherType(), $prof);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.prof']->save($prof);
                $message = 'Le prof à été modifié !.';
                $app['session']->getFlashBag()->add('success', $message);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Edition d\'un prof',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function deleteAction(Request $request, Application $app)
    {
        $prof = $request->attributes->get('prof');
        if (!$prof) {
            $app->abort(404, 'The requested prof was not found.');
        }
        $app['repository.prof']->delete($prof);
        return $app->redirect($app['url_generator']->generate('admin_teachers'));
    }

}