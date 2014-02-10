<?php

// Autoload Composer
require_once __DIR__.'/../vendor/autoload.php';

//Init silex application
$app = new Silex\Application();


//Debug
$app['debug'] = true;

//load config
require_once __DIR__.'/../config/database.php';

//init Database
$app['sql'] = new Blog\Sql(
    $config['server'],
    $config['database'],
    $config['id'],
    $config['password']
);

//Register twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
//register service url generator
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
//register service session
$app->register(new Silex\Provider\SessionServiceProvider());

//Création route home
$app->get('/', function () use ($app) {
    $c = new HomeController($app);
    return $c->getIndex();
})
->bind('home');

//Création route /admin
$app->get('/admin', function () use ($app) {
    $c = new AdminController($app);
    return $c->getArticle();
})
->bind('getAdmin');

//route post /admin
$app->post('/admin', function () use ($app) {
    $c = new AdminController($app);
    return $c->postArticle();
})
->bind('postAdmin');

//route user login
$app->get('/login', function () use ($app) {
    $c = new UserController($app);
    return $c->getLogin();
})
->bind('login');

//route user login
$app->post('/login', function () use ($app) {
    $c = new UserController($app);
    return $c->postLogin();
})
->bind('postLogin');

//route user login
$app->get('/register', function () use ($app) {
    $c = new UserController($app);
    return $c->getRegister();
})
->bind('register');

//route user login
$app->post('/register', function () use ($app) {
    $c = new UserController($app);
    return $c->postRegister();
})
->bind('postRegister');

//run app
$app->run();
