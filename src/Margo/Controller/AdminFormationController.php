<?php

namespace Margo\Controller;

use Margo\Entity\Formation;
use Margo\Form\Type\FormationType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class AdminFormationController
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
            'here' => $app['url_generator']->generate('admin_formations'),
        );
        return $app['twig']->render('adminFormation.html.twig', $data);

    }

    public function addAction(Request $request, Application $app)
    {
        $formation = new Formation();
        $form = $app['form.factory']->create(new FormationType(), $formation);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.formation']->save($formation);
                $message = 'La classe ' . $formation->getNameFormation() . ' à été ajouté.';
                $app['session']->getFlashBag()->add('success', $message);
                // Redirect to the edit page.
                $redirect = $app['url_generator']->generate('admin_formation_add', array('category' => $formation->getIdFormation()));
                return $app->redirect($redirect);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Ajout d\'une formation',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function editAction(Request $request, Application $app)
    {
        $formation = $request->attributes->get('formation');
        if (!$formation) {
            $app->abort(404, 'La  formation n\'a pas été trouvé.');
        }
        $form = $app['form.factory']->create(new FormationType(), $formation);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.formation']->save($formation);
                $message = 'La formation à été modifié !.';
                $app['session']->getFlashBag()->add('success', $message);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Edition d\'une formation',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

    public function deleteAction(Request $request, Application $app)
    {
        $formation = $request->attributes->get('formation');
        if (!$formation) {
            $app->abort(404, 'La formation n\'a pas été trouvé.');
        }

        $category = $app['repository.category']->selectOneByNameFormation($formation->getNameFormation());
        if (!empty($category)) {
            $message = 'Impossible de supprimer : une ou plusieurs classes sont inscrits à cette formation';
            $app['session']->getFlashBag()->add('error', $message);
        } else {
            $app['repository.formation']->delete($formation);
            $message = 'Suppression de la formation';
            $app['session']->getFlashBag()->add('success', $message);
        }

        return $app->redirect($app['url_generator']->generate('admin_formations'));
    }

}