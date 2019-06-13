<?php
    // Session management
    session_start();

    // Use space
    use Medoo\Medoo;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    // Include composer
    require 'vendor/autoload.php';

    // Helper functions
    function is_loggedin()
    {
        if ( empty($_SESSION['role']) )
        {
            header("Location: /login");
            exit();
        }
    }

    // Define new app
    $app = new \Slim\App;

    // Fetch DI Container
    $container = $app->getContainer();

    // Register Twig View helper
    $container['db'] = function () {
        $database = new Medoo([
            #'database_type' => 'sqlite',
            #'database_file' => 'store.db'
            'database_type' => 'mysql',
            'database_name' => 'agile2_bd',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
        ]);

        return $database;
    };

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
        is_loggedin();
        return $this->view->render($response, 'dashboard.html');
    });

    $app->get('/login', function (Request $request, Response $response, array $args) {
        if ( !empty($_SESSION['role']) )
        {
            header("Location: /");
            exit();
        }

        return $this->view->render($response, 'login.html');
    });
	
	$app->get('/addAbsence', function (Request $request, Response $response, array $args) {
        is_loggedin();
        return $this->view->render($response, 'addAbsence.html');
    });

    $app->get('/logout', function (Request $request, Response $response, array $args) {
        session_destroy();    
        header("Location: /login");
        exit();
    });

    $app->run();