<?php

namespace Margo\Controller;

use Margo\Entity\Category;
use Margo\Form\Type\CategoryType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class AdminCategoryController
{

    public function indexAction(Request $request, Application $app)
    {
        // Perform pagination logic.
        $limit = 10;
        $total = $app['repository.category']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $classes = $app['repository.category']->findAll($limit, $offset);
        $data = array(
            'classes' => $classes,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('admin_categories'),
        );
        return $app['twig']->render('adminCategory.html.twig', $data);

    }

    public function addAction(Request $request, Application $app)
    {
        $category = new Category();
        $form = $app['form.factory']->create(new CategoryType(), $category);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.category']->save($category);
                $message = 'La classe ' . $category->getCategName() . ' à été ajouté.';
                $app['session']->getFlashBag()->add('success', $message);
                // Redirect to the edit page.
                $redirect = $app['url_generator']->generate('admin_category_add', array('category' => $category->getCategId()));
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
        $category = $request->attributes->get('classe');
        if (!$category) {
            $app->abort(404, 'La classe n\'a pas été trouvé.');
        }
        $form = $app['form.factory']->create(new CategoryType(), $category);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.category']->save($category);
                $message = 'La classe à été modifié !.';
                $app['session']->getFlashBag()->add('success', $message);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Edition d\'une classe',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function deleteAction(Request $request, Application $app)
    {
        $classe = $request->attributes->get('classe');
        if (!$classe) {
            $app->abort(404, 'The requested prof was not found.');
        }

        $student = $app['repository.etudiant']->selectOneByIdCateg($classe->getCategId());
        if (!empty($student)) {
            $message = 'Impossible de supprimer : un ou plusieurs étudiants sont inscrits à cette classe';
            $app['session']->getFlashBag()->add('error', $message);
        } else {
            $app['repository.category']->delete($classe);
        }

        return $app->redirect($app['url_generator']->generate('admin_categories'));
    }

}