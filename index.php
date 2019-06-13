<?php
    // Session management
    session_start();

    // session_destroy();

    // Use space
    use Medoo\Medoo;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    // Include composer
    require 'vendor/autoload.php';

    // Database init
    $database = new Medoo([
        'database_type' => 'sqlite',
        'database_file' => 'store.db'
    ]);

    // Define new app
    $app = new \Slim\App;

    // Fetch DI Container
    $container = $app->getContainer();

    // Register Twig View helper
    $container['view'] = function ($c) {
        $view = new \Slim\Views\Twig('templates', [
            //'cache' => 'path/to/cache'
        ]);
        
        // Instantiate and add Slim specific extension
        $router = $c->get('router');
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

        return $view;
    };

    $app->get('/', function (Request $request, Response $response, array $args) {
        if ( empty($_SESSION['login']) )
        {
            header("Location: /login");
            exit();
        }

        return $this->view->render($response, 'dashboard.html');
    });

    $app->get('/login', function (Request $request, Response $response, array $args) {
        if ( !empty($_SESSION['login']) )
        {
            header("Location: /");
            exit();
        }

        return $this->view->render($response, 'login.html', [
            //'name' => $args['name']
        ]);
    });

    $app->get('/addAbsence', function (Request $request, Response $response, array $args) {
        if ( empty($_SESSION['login']) )
        {
            header("Location: /login");
            exit();
        }

        return $this->view->render($response, 'addAbsence.html', [
            //'name' => $args['name']
        ]);
    });

    $app->get('/logout', function (Request $request, Response $response, array $args) {
        session_destroy();    
        header("Location: /login");
        exit();
    });

    $app->run();