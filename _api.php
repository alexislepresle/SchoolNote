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
    function is_valid_json( $r ){
        return ( json_decode( $r , true ) == NULL ) ? false : true ; // Yes! thats it.
    }

    // More definition stuff
    define("RETURN_SUCCESS", 1);
    define("RETURN_ERROR", 2);
    define("RETURN_UNKNOWN", 3);

    // Define new app
    $app = new \Slim\App;

    // Fetch DI Container
    $container = $app->getContainer();

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
    //logout

    //dashboard
    $app->get('/dashboard', function (Request $request, Response $response, array $args) {
        $data = $this->db->query("SELECT DATE_FORMAT(`DATEBEGIN`, '%d/%m/%Y'), `CODEMODULE`, CONCAT('UE ', `N_UE`), CONCAT(`FIRSTNAMESTUDENT`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMESTUDENT`,1,1)),LOWER(SUBSTRING(`LASTNAMESTUDENT`,2)))) AS `NAME` FROM `absence` LEFT JOIN `module` ON `absence`.`N_MODULE` = `module`.`N_MODULE` LEFT JOIN `student` ON `student`.`N_STUDENT` = `absence`.`N_STUDENT`")->fetchAll(PDO::FETCH_NUM);

        return $response->withJson(["data" => $data]);
    });

    // getabsence
    $app->post('/getabsence', function (Request $request, Response $response, array $args) {
        return;
    });

    //addabsence

    $app->post('/login', function (Request $request, Response $response, array $args) {
        if ( !is_valid_json($request->getBody()) )
            return $response->withJson(["code" => RETURN_ERROR, "data" => "Invalid request. Please try again."]);

        $var = json_decode($request->getBody());

        if ( empty($var->email) || empty($var->password) )
            return $response->withJson(["code" => RETURN_ERROR, "data" => "Please fill in all fields."]);

        $query = $this->db->select("users", [
            "salt",
            "role"
        ], [
            "AND" => [
                "email" => $var->email,
                "password" => $var->password
            ]
        ]);

        if ( !is_array($query) || count($query) != 1 )
            return $response->withJson(["code" => RETURN_ERROR, "data" => "Wrong email or password."]);

        $_SESSION['login'] = session_id();

        return $response->withJson(["code" => RETURN_SUCCESS, "data" => "All good."]);
    });
    $app->run();