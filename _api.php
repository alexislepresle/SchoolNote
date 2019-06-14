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
    define("ROLE_DIRECTOR", 3);

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
		switch ( $_SESSION['role'] )
		{
			case ROLE_STUDENT:
				$data = $this->db->query("SELECT DATE_FORMAT(`DATEBEGIN`, '%d/%m/%Y'), `CODEMODULE`, 
										`CODEUE`, `CODETYPE`, `IS_DELAY`, CONCAT(`FIRSTNAMETEACHER`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMETEACHER`,1,1)),LOWER(SUBSTRING(`LASTNAMETEACHER`,2)))) AS `TNAME`, CONCAT(`FIRSTNAMESTUDENT`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMESTUDENT`,1,1)),LOWER(SUBSTRING(`LASTNAMESTUDENT`,2)))) AS `SNAME`, 
										`STATUSABSENCE`, `N_ABSENCE` 
										FROM `ABSENCE` 
										LEFT JOIN `MODULE` ON `ABSENCE`.`N_MODULE` = `MODULE`.`N_MODULE` 
										LEFT JOIN `UE` ON `UE`.`N_UE` = `MODULE`.`N_UE` 
										LEFT JOIN `LESSON_TYPE` ON `LESSON_TYPE`.`N_TYPE` = `ABSENCE`.`N_TYPE` 
										LEFT JOIN `TEACHER` ON `TEACHER`.`N_TEACHER` = `ABSENCE`.`N_TEACHER` 
										LEFT JOIN `STUDENT` ON `STUDENT`.`N_STUDENT` = `ABSENCE`.`N_STUDENT` 
										WHERE `ABSENCE`.`N_STUDENT` = {$_SESSION['id']}")->fetchAll(PDO::FETCH_NUM);
				break;
				
			case ROLE_TEACHER:
			case ROLE_DIRECTOR:
				$data = $this->db->query("SELECT DATE_FORMAT(`DATEBEGIN`, '%d/%m/%Y'), `CODEMODULE`, 
							`CODEUE`, `CODETYPE`, `IS_DELAY`, CONCAT(`FIRSTNAMETEACHER`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMETEACHER`,1,1)),LOWER(SUBSTRING(`LASTNAMETEACHER`,2)))) AS `TNAME`, CONCAT(`FIRSTNAMESTUDENT`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMESTUDENT`,1,1)),LOWER(SUBSTRING(`LASTNAMESTUDENT`,2)))) AS `SNAME`, 
							`STATUSABSENCE`, `N_ABSENCE` 
							FROM `ABSENCE` 
							LEFT JOIN `MODULE` ON `ABSENCE`.`N_MODULE` = `MODULE`.`N_MODULE` 
							LEFT JOIN `UE` ON `UE`.`N_UE` = `MODULE`.`N_UE` 
							LEFT JOIN `LESSON_TYPE` ON `LESSON_TYPE`.`N_TYPE` = `ABSENCE`.`N_TYPE` 
							LEFT JOIN `TEACHER` ON `TEACHER`.`N_TEACHER` = `ABSENCE`.`N_TEACHER` 
							LEFT JOIN `STUDENT` ON `STUDENT`.`N_STUDENT` = `ABSENCE`.`N_STUDENT`")->fetchAll(PDO::FETCH_NUM);
				break;
		}
        
        return $response->withJson(["data" => $data]);
    });

    $app->get('/getmodule', function (Request $request, Response $response, array $args) {
		$data = $this->db->query("SELECT `N_MODULE`, `CODEMODULE` FROM `MODULE`")->fetchAll(PDO::FETCH_NUM);;
        return $response->withJson($data);
    });
	
	$app->post('/getue', function (Request $request, Response $response, array $args) {
		$var = json_decode($request->getBody());
		$id = $this->db->get("MODULE", "N_UE", [ "N_MODULE" => $var->data ]);
		$data = $this->db->query("SELECT `N_UE`, `CODEUE` FROM `UE` WHERE `N_UE` = '$id'")->fetchAll(PDO::FETCH_NUM);
        return $response->withJson($data);
    });
	
	$app->post('/autoname', function (Request $request, Response $response, array $args) {
		
		$var = json_decode($request->getBody());
		
		$query = $this->db->select("STUDENT", [
			'name' => Medoo::raw("CONCAT(<FIRSTNAMESTUDENT>, ' ',<LASTNAMESTUDENT>, ' (', <N_STUDENT>, ')')")
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
		
		for ($i=0; $i<=9; $i++)
		{
			
			if ( empty($var->{student . $i}) )
				continue;			

			$temp = explode('(', rtrim($var->{student . $i},')'));
			
			$this->db->insert("ABSENCE", [
				"N_MODULE" => $var->module,
				"N_TEACHER" => $_SESSION['id'],
				"N_STUDENT" => $temp[1],
				"N_TYPE" => 1,
				"EVALUATED_LESSON" => $var->evaluated,
				"STATUSABSENCE" => ($var->justify == 'on')?1:0,
				"DATEBEGIN" => $start,
				"DATEEND" => $end,
				"IS_DELAY" => ($var->delay == 'on')?1:0,
				"COMMENT" => $var->comment
			]);
		}
		
		return $response->withJson(["code" => RETURN_SUCCESS, "data" => "All good."]);
    });

    $app->post('/login', function (Request $request, Response $response, array $args) {
        if ( !is_valid_json($request->getBody()) )
            return $response->withJson(["code" => RETURN_ERROR, "data" => "Invalid request. Please try again."]);

        $var = json_decode($request->getBody());

        if ( empty($var->email) || empty($var->password) )
            return $response->withJson(["code" => RETURN_ERROR, "data" => "Please fill in all fields."]);

        if ( strpos($var->email, 'etu.unicaen.fr') !== false )
        {
            $id = $this->db->get("STUDENT", "N_STUDENT", 
			[
                "AND" => [
                    "MAILSTUDENT" => $var->email,
                    "PASSWORDSTUDENT" => $var->password
                ]
            ]);

            $role = ROLE_STUDENT;
        }
        else
        {
            $id = $this->db->get("TEACHER", "N_TEACHER",
			[
                "AND" => [
                    "MAILTEACHER" => $var->email,
                    "PASSWORDTEACHER" => $var->password
                ]
            ]);
			
			$director = $this->db->get("TEACHER", "IS_DIRECTOR_OF_STUDIES",
			[
                "AND" => [
                    "MAILTEACHER" => $var->email,
                    "PASSWORDTEACHER" => $var->password
                ]
            ]);

			if ( $director )
				$role = ROLE_DIRECTOR;
			else
				$role = ROLE_TEACHER;
        }

        if ( empty($id) )
            return $response->withJson(["code" => RETURN_ERROR, "data" => "Wrong email or password."]);

        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;
        $_SESSION['mail'] = $var->email;

        return $response->withJson(["code" => RETURN_SUCCESS, "data" => "All good."]);
    });
    $app->run();