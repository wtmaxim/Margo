<?php

namespace Margo\Controller;

use Margo\Entity\Teacher;
use Margo\Form\Type\TeacherType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class AdminTeacherController {

    public function indexAction(Request $request, Application $app) {
        // Perform pagination logic.
        $limit = 100;
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

    public function addAction(Request $request, Application $app) {
        $teacher = new Teacher();
        $form = $app['form.factory']->create(new TeacherType(), $teacher);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            $name = $teacher->getSubject();
            $subject = $app['repository.subject']->selectOneByName($name);
            if ($form->isValid() && !empty($subject)) {
                if (preg_match('/^[a-zA-Z\s]+$/', $teacher->getName()) && preg_match('/^[a-zA-Z\s]+$/', $teacher->getFirstName())) {
                    $app['repository.prof']->save($teacher);
                    $message = 'Le prof ' . $teacher->getName() . ' à été ajouté.';
                    $app['session']->getFlashBag()->add('success', $message);
                    // Redirect to the edit page.
                    $redirect = $app['url_generator']->generate('admin_teacher_add', array('prof' => $teacher->getTeacherId()));
                    return $app->redirect($redirect);
                } else {
                    $message = 'Les champs de noms et prénoms ne doivent pas comportés de caractère spéciaux ni de chiffres';
                    $app['session']->getFlashBag()->add('error', $message);
                    $redirect = $app['url_generator']->generate('admin_teacher_add', array('teacher' => $teacher->getTeacherId()));
                    return $app->redirect($redirect);
                }
            } else {
                $message = 'La matière inscrite n\'existe pas.';
                $app['session']->getFlashBag()->add('error', $message);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Ajout d\'un prof',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function editAction(Request $request, Application $app) {
        $prof = $request->attributes->get('prof');
        $form = $app['form.factory']->create(new TeacherType(), $prof);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $name = $prof->getSubject();
            $subject = $app['repository.subject']->selectOneByName($name);
            if ($form->isValid() && !empty($subject)) {
                if (preg_match('/^[a-zA-Z\s]+$/', $teacher->getName()) && preg_match('/^[a-zA-Z\s]+$/', $teacher->getFirstName())) {
                $app['repository.prof']->save($prof);
                $message = 'Le prof à été modifié !.';
                $app['session']->getFlashBag()->add('success', $message);
                }else{
                    $message = 'Les champs de noms et prénoms ne doivent pas comportés de caractère spéciaux ni de chiffres';
                    $app['session']->getFlashBag()->add('error', $message);
                    $redirect = $app['url_generator']->generate('admin_teacher_edit', array('teacher' => $teacher->getTeacherId()));
                    return $app->redirect($redirect);
                }
            } else {
                $message = 'La matière inscrite n\'existe pas.';
                $app['session']->getFlashBag()->add('error', $message);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Edition d\'un prof',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function deleteAction(Request $request, Application $app) {
        $prof = $request->attributes->get('prof');
        if (!$prof) {
            $app->abort(404, 'The requested prof was not found.');
        }
        $app['repository.prof']->delete($prof);
        return $app->redirect($app['url_generator']->generate('admin_teachers'));
    }

}
