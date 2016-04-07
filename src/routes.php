<?php

// Register route converters.
// Each converter needs to check if the $id it received is actually a value,
// as a workaround for https://github.com/silexphp/Silex/pull/768.
$app['controllers']->convert('etudiant', function ($id) use ($app) {
    if ($id) {
        return $app['repository.etudiant']->find($id);
    }
});
$app['controllers']->convert('prof', function ($id) use ($app) {
    if ($id) {
        return $app['repository.prof']->find($id);
    }
});

$app['controllers']->convert('user', function ($id) use ($app) {
    if ($id) {
        return $app['repository.user']->find($id);
    }
});

// Register routes.
$app->get('/', 'Margo\Controller\IndexController::indexAction')
    ->bind('homepage');

// Login route
$app->match('/login', 'Margo\Controller\UserController::loginAction')
    ->bind('login');
$app->get('/logout', 'Margo\Controller\UserController::logoutAction')
    ->bind('logout');

// Admin root
$app->get('/admin', 'Margo\Controller\AdminController::indexAction')
    ->bind('admin');

// Admin route eleve
$app->get('/admin/etudiants', 'Margo\Controller\StudentController::indexAction')
    ->bind('admin_etudiants');
$app->match('/admin/etudiant/add', 'Margo\Controller\StudentController::addAction')
    ->bind('admin_etudiant_add');
$app->match('/admin/etudiants/{etudiant}/edit', 'Margo\Controller\StudentController::editAction')
    ->bind('admin_etudiant_edit');
$app->match('/admin/etudiants/{etudiant}/delete', 'Margo\Controller\StudentController::deleteAction')
    ->bind('admin_etudiant_delete');

$app->get('/admin/teachers', 'Margo\Controller\TeacherController::indexAction')
    ->bind('admin_teachers');
$app->match('/admin/teacher/add', 'Margo\Controller\AdminProfController::addAction')
    ->bind('admin_teacher_add');
$app->match('/admin/teacher/{teacher}/edit', 'Margo\Controller\AdminProfController::editAction')
    ->bind('admin_teacher_edit');
$app->match('/admin/teacher/{teacher}/delete', 'Margo\Controller\TeacherController::deleteAction')
    ->bind('admin_teacher_delete');

$app->get('/admin/users', 'Margo\Controller\AdminUserController::indexAction')
    ->bind('admin_users');
$app->match('/admin/users/add', 'Margo\Controller\AdminUserController::addAction')
    ->bind('admin_user_add');
$app->match('/admin/users/{user}/edit', 'Margo\Controller\AdminUserController::editAction')
    ->bind('admin_user_edit');
$app->match('/admin/users/{user}/delete', 'Margo\Controller\AdminUserController::deleteAction')
    ->bind('admin_user_delete');

