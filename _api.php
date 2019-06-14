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
										`CODEUE`, `CODETYPE`, `IS_DELAY`, `EVALUATED_LESSON`, CONCAT(`FIRSTNAMETEACHER`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMETEACHER`,1,1)),LOWER(SUBSTRING(`LASTNAMETEACHER`,2)))) AS `TNAME`, CONCAT(`FIRSTNAMESTUDENT`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMESTUDENT`,1,1)),LOWER(SUBSTRING(`LASTNAMESTUDENT`,2)))) AS `SNAME`, 
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
				$data = $this->db->query("SELECT DATE_FORMAT(`DATEBEGIN`, '%d/%m/%Y'), `CODEMODULE`, 
							`CODEUE`, `CODETYPE`, `IS_DELAY`, `EVALUATED_LESSON`, CONCAT(`FIRSTNAMETEACHER`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMETEACHER`,1,1)),LOWER(SUBSTRING(`LASTNAMETEACHER`,2)))) AS `TNAME`, CONCAT(`FIRSTNAMESTUDENT`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMESTUDENT`,1,1)),LOWER(SUBSTRING(`LASTNAMESTUDENT`,2)))) AS `SNAME`, 
							`STATUSABSENCE`, `N_ABSENCE` 
							FROM `ABSENCE` 
							LEFT JOIN `MODULE` ON `ABSENCE`.`N_MODULE` = `MODULE`.`N_MODULE` 
							LEFT JOIN `UE` ON `UE`.`N_UE` = `MODULE`.`N_UE` 
							LEFT JOIN `LESSON_TYPE` ON `LESSON_TYPE`.`N_TYPE` = `ABSENCE`.`N_TYPE` 
							LEFT JOIN `TEACHER` ON `TEACHER`.`N_TEACHER` = `ABSENCE`.`N_TEACHER` 
							LEFT JOIN `STUDENT` ON `STUDENT`.`N_STUDENT` = `ABSENCE`.`N_STUDENT` 
							WHERE `ABSENCE`.`N_TEACHER` = {$_SESSION['id']}")->fetchAll(PDO::FETCH_NUM);
				break;
				
			case ROLE_DIRECTOR:
				$data = $this->db->query("SELECT DATE_FORMAT(`DATEBEGIN`, '%d/%m/%Y'), `CODEMODULE`, 
							`CODEUE`, `CODETYPE`, `IS_DELAY`, `EVALUATED_LESSON`, CONCAT(`FIRSTNAMETEACHER`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMETEACHER`,1,1)),LOWER(SUBSTRING(`LASTNAMETEACHER`,2)))) AS `TNAME`, CONCAT(`FIRSTNAMESTUDENT`, ' ', CONCAT(UPPER(SUBSTRING(`LASTNAMESTUDENT`,1,1)),LOWER(SUBSTRING(`LASTNAMESTUDENT`,2)))) AS `SNAME`, 
							`STATUSABSENCE`, `N_ABSENCE` 
							FROM `ABSENCE` 
							LEFT JOIN `MODULE` ON `ABSENCE`.`N_MODULE` = `MODULE`.`N_MODULE` 
							LEFT JOIN `UE` ON `UE`.`N_UE` = `MODULE`.`N_UE` 
							LEFT JOIN `LESSON_TYPE` ON `LESSON_TYPE`.`N_TYPE` = `ABSENCE`.`N_TYPE` 
							LEFT JOIN `TEACHER` ON `TEACHER`.`N_TEACHER` = `ABSENCE`.`N_TEACHER` 
							LEFT JOIN `STUDENT` ON `STUDENT`.`N_STUDENT` = `ABSENCE`.`N_STUDENT`")->fetchAll(PDO::FETCH_NUM);
				break;
		}
		
		foreach ( $data as &$value )
		{
			if ( $_SESSION['role'] == ROLE_STUDENT ) {
				$value[9] = '';
				continue;
			}
			
			$id = $value[9];
			
			if ( $_SESSION['role'] >= ROLE_TEACHER )
				$value[9] = "<i data-id='{$id}' style='cursor:pointer;' class='fas fa-trash submitDelete'></i>";
			
			if ( $_SESSION['role'] >= ROLE_DIRECTOR )
				$value[9] .= " <i data-id='{$id}' style='cursor:pointer;' class='fas fa-check-circle submitValidate'></i>";
		}
        
        return $response->withJson(["data" => $data]);
    });

    $app->get('/getmodule', function (Request $request, Response $response, array $args) {
		$data = $this->db->query("SELECT `N_MODULE`, `CODEMODULE` FROM `MODULE`")->fetchAll(PDO::FETCH_NUM);
        return $response->withJson($data);
    });
	
	$app->post('/getue', function (Request $request, Response $response, array $args) {
		$var = json_decode($request->getBody());
		$id = $this->db->get("MODULE", "N_UE", [ "N_MODULE" => $var->data ]);
		$data = $this->db->query("SELECT `N_UE`, `CODEUE` FROM `UE` WHERE `N_UE` = '$id'")->fetchAll(PDO::FETCH_NUM);
        return $response->withJson($data);
    });
	
	$app->post('/delabsence', function (Request $request, Response $response, array $args) {
		$var = json_decode($request->getBody());
		$this->db->delete("ABSENCE", [ "N_ABSENCE" => $var->id ]);
        return;
    });
	
	$app->post('/valabsence', function (Request $request, Response $response, array $args) {
		$var = json_decode($request->getBody());
		
		#$data = $this->db->query("SELECT ");
		
		$this->db->query("UPDATE `ABSENCE` SET `STATUSABSENCE` = IF(STATUSABSENCE=1, 0, 1) WHERE `N_ABSENCE` = {$var->id}");
        return;
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
			
			$email = $this->db->get("STUDENT", "MAILSTUDENT", [ "N_STUDENT" => $temp[1] ]);
			$code = $this->db->get("MODULE", "CODEMODULE", [ "N_MODULE" => $var->module ]);
			
			//mail($_SESSION['mail'], "lehrermail", "für den lehrer");
			//mail($email, "studentmail", "für den student");
			
			$teacher_mail = "You added an absence for %s for a lesson of the module %s at %s from %s to %s.
Sent from SchoolNote.";

			$student_mail = "You were absent for the lesson of the module %s at %s from %s to %s.";
			
			if ( $var->evaluated )
				$student_mail .= "Furthermore this lesson was evaluated, you have only 3 days to justify your absence and then be able to catch up with this evaluated lesson.";

			$student_mail .= "Please contact the Head of Studies to justify your absence.
Sent from SchoolNote.";
								
			mail($_SESSION['mail'], "Teacher mail", sprintf($teacher_mail, $email, $code, $var->date, $var->beggingHour, $var->endHour));
			mail($email, "Student mail", sprintf($student_mail, $code, $var->date, $var->beggingHour, $var->endHour));
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