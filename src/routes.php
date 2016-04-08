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
$app['controllers']->convert('classe', function ($id) use ($app) {
   if ($id) {
       return $app['repository.category']->find($id);
   }
});


// Register routes.
$app->get('/', 'Margo\Controller\IndexController::indexAction')
    ->bind('homepage');

$app->get('/student', 'Margo\Controller\StudentController::indexAction');

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
//admin route prof
$app->get('/admin/teachers', 'Margo\Controller\TeacherController::indexAction')
    ->bind('admin_teachers');
$app->match('/admin/teachers/add', 'Margo\Controller\TeacherController::addAction')
    ->bind('admin_teacher_add');
$app->match('/admin/teachers/{prof}/edit', 'Margo\Controller\TeacherController::editAction')
    ->bind('admin_teacher_edit');
$app->match('/admin/teachers/{prof}/delete', 'Margo\Controller\TeacherController::deleteAction')
    ->bind('admin_teacher_delete');

//admin route utilisateurs
$app->get('/admin/users', 'Margo\Controller\AdminUserController::indexAction')
    ->bind('admin_users');
$app->match('/admin/users/add', 'Margo\Controller\AdminUserController::addAction')
    ->bind('admin_user_add');
$app->match('/admin/users/{user}/edit', 'Margo\Controller\AdminUserController::editAction')
    ->bind('admin_user_edit');
$app->match('/admin/users/{user}/delete', 'Margo\Controller\AdminUserController::deleteAction')
    ->bind('admin_user_delete');

//admin route classe
$app->get('/admin/categories', 'Margo\Controller\CategoryController::indexAction')
    ->bind('admin_categories');
$app->match('/admin/categories/add', 'Margo\Controller\CategoryController::addAction')
    ->bind('admin_category_add');
$app->match('/admin/categories/{classe}/edit', 'Margo\Controller\CategoryController::editAction')
    ->bind('admin_category_edit');
$app->match('/admin/categories/{classe}/delete', 'Margo\Controller\CategoryController::deleteAction')
    ->bind('admin_category_delete');