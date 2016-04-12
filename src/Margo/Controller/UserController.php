<?php

namespace Margo\Controller;

use Margo\Entity\User;
use Margo\Form\Type\UserType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    public function meAction(Request $request, Application $app)
    {
        $token = $app['security']->getToken();
        $user = $token->getUser();
        $now = new \DateTime();
        $interval = $now->diff($user->getCreatedAt());
        $memberSince = $interval->format('%d days %H hours %I minutes ago');
        $limit = 60;
        $likes = $app['repository.like']->findAllByUser($user->getId(), $limit);
        // Divide artists into groups of 6.
        $groupSize = 6;
        $groupedLikes = array();
        $progress = 0;
        while ($progress < $limit) {
            $groupedLikes[] = array_slice($likes, $progress, $groupSize);
            $progress += $groupSize;
        }

        $data = array(
            'user' => $user,
            'memberSince' => $memberSince,
            'groupedLikes' => $groupedLikes,
        );
        return $app['twig']->render('profile.html.twig', $data);
    }

    public function loginAction(Request $request, Application $app)
    {
        $form = $app['form.factory']->createBuilder('form')
            ->add('username', 'text', array('label' => 'Username', 'data' => $app['session']->get('_security.last_username')))
            ->add('password', 'password', array('label' => 'Password'))
            ->add('login', 'submit')
            ->getForm();

        $data = array(
            'form'  => $form->createView(),
            'error' => $app['security.last_error']($request),
        );
        return $app['twig']->render('login.html.twig', $data);
    }

    public function logoutAction(Request $request, Application $app)
    {
        $app['session']->clear();
        return $app->redirect($app['url_generator']->generate('homepage'));
    }

    public function indexAction(Request $request, Application $app)
    {
        // Perform pagination logic.
        $limit = 10;
        $total = $app['repository.user']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $users = $app['repository.user']->findAll($limit, $offset);
        $data = array(
            'users' => $users,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('admin_users'),
        );
        return $app['twig']->render('adminUser.html.twig', $data);

    }


    public function addAction(Request $request, Application $app)
    {
        $user = new User();
        $form = $app['form.factory']->create(new UserType(), $user);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.user']->save($user);
                $message = 'L\'utilisateur ' . $user->getUserName() . ' à été ajouté.';
                $app['session']->getFlashBag()->add('success', $message);
                // Redirect to the edit page.
                $redirect = $app['url_generator']->generate('admin_user_add', array('user' => $user->getId()));
                return $app->redirect($redirect);
            }
        }
        $data = array(
            'form' => $form->createView(),
            'title' => 'Ajout d\'un utilisateur',
        );
        return $app['twig']->render('form.html.twig', $data);
    }

}
