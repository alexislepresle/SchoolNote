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

    define("ROLE_STUDENT", 1);
    define("ROLE_TEACHER", 2);

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
            'username' => 'agile2',
            'password' => 'iesh1Dah6Iet8rai'
        ]);

        return $database;
    };

    //dashboard
    $app->get('/dashboard', function (Request $request, Response $response, array $args) {
        $data = $this->db->query("SELECT DATE_FORMAT(`DATEBEGIN`, '%d/%m/%Y'), `CODEMODULE`, CONCAT('UE ', `N_UE`), CONCAT(`FIRSTNAMESTUDENT`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMESTUDENT`,1,1)),LOWER(SUBSTRING(`LASTNAMESTUDENT`,2)))) AS `NAME` FROM `ABSENCE` LEFT JOIN `MODULE` ON `ABSENCE`.`N_MODULE` = `MODULE`.`N_MODULE` LEFT JOIN `STUDENT` ON `STUDENT`.`N_STUDENT` = `ABSENCE`.`N_STUDENT`")->fetchAll(PDO::FETCH_NUM);
        return $response->withJson(["data" => $data]);
    });

    $app->get('/getmodule', function (Request $request, Response $response, array $args) {
		$data = $this->db->query("SELECT `N_MODULE`, `CODEMODULE` FROM `MODULE`")->fetchAll(PDO::FETCH_NUM);;
        return $response->withJson($data);
    });
	
	$app->post('/getue', function (Request $request, Response $response, array $args) {
		
		$var = json_decode($request->getBody());

		$query = $this->db->select("MODULE", [
			"N_UE"
		], [
			"N_MODULE" => $var->data
		]);

		$data = $this->db->query("SELECT `N_UE`, `CODEUE` FROM `UE` WHERE `N_UE` = '{$query[0]['N_UE']}'")->fetchAll(PDO::FETCH_NUM);
        return $response->withJson($data);
    });
	
	$app->post('/autoname', function (Request $request, Response $response, array $args) {
		
		$var = json_decode($request->getBody());
		
		$query = $this->db->select("STUDENT", [
			'name' => Medoo::raw("CONCAT(<FIRSTNAMESTUDENT>, ' ',<LASTNAMESTUDENT>)")
		], [
			"FIRSTNAMESTUDENT[~]" => $var->data
		]);
		
		return $response->withJson($query);
    });

    //addabsence
	$app->post('/addabsence', function (Request $request, Response $response, array $args) {
		
		$var = json_decode($request->getBody());
		
		$start = $var->date . ' ' . $var->beggingHour . ':00';
		$end = $var->date . ' ' . $var->endHour . ':00';
		
		$this->db->insert("ABSENCE", [
			"N_MODULE" => $var->module,
			"N_TEACHER" => 1,
			"N_STUDENT" => "21504680",
			"N_TYPE" => $var->classType,
			"STATUSABSENCE" => ($var->justify == 'on')?1:0,
			"DATEBEGIN" => $start,
			"DATEEND" => $end,
			"IS_DELAY" => ($var->delay == 'on')?1:0,
			"COMMENT" => $var->comment
		]);
		
		echo $start;
		echo "<br>";
		echo $end;
		return;
		
		return $response->withJson($query);
    });

    $app->post('/login', function (Request $request, Response $response, array $args) {
        if ( !is_valid_json($request->getBody()) )
            return $response->withJson(["code" => RETURN_ERROR, "data" => "Invalid request. Please try again."]);

        $var = json_decode($request->getBody());

        if ( empty($var->email) || empty($var->password) )
            return $response->withJson(["code" => RETURN_ERROR, "data" => "Please fill in all fields."]);

        if ( strpos($var->email, 'etu.unicaen.fr') !== false )
        {
            $query = $this->db->select("STUDENT", [
                "N_STUDENT"
            ], [
                "AND" => [
                    "MAILSTUDENT" => $var->email,
                    "PASSWORDSTUDENT" => $var->password
                ]
            ]);

            $role = ROLE_STUDENT;
        }
        else
        {
            $query = $this->db->select("TEACHER", [
                "N_TEACHER"
            ], [
                "AND" => [
                    "MAILTEACHER" => $var->email,
                    "PASSWORDTEACHER" => $var->password
                ]
            ]);

            $role = ROLE_TEACHER;
        }

        if ( !is_array($query) || count($query) != 1 )
            return $response->withJson(["code" => RETURN_ERROR, "data" => "Wrong email or password."]);

        $_SESSION['role'] = $role;

        return $response->withJson(["code" => RETURN_SUCCESS, "data" => "All good."]);
    });
    $app->run();