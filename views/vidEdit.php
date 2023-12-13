<?php 
	/* Create DB connection to Query Database for Artist info */
		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

		include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

	
	if($_FILES){
		var_dump($_FILES);
	}
	if($_POST){
		/* Define & Unset table element in $_POST array */
			$table = $_POST['table'];
			unset($_POST['table']);

			

		if($_POST['action'] == 'saveChanges'){
			/* Unset action element in the $_POST array & define the $cond parameter for the update function */
				unset($_POST['action']);
				$cond = 'id = ' . $_POST['id'];

			/* Define field and value arrays for the update function's parameters */
				foreach($_POST as $index => $values){
					$field[] = $index; 
					$value[] = $values; 
				}

			// var_dump($field);
			// var_dump($value);
			// $updateSuccessful = $obj->update($field,$value,$cond,$table);
		}
		elseif($_POST['action'] == 'removeVideo'){
			/* Unset action element in the $_POST array & define the $cond parameter for the update function */
				unset($_POST['action']);
				$cond = 'id = ' . $_POST['id'];

			// $delSuccessful = $obj->delete($table, $cond);
		}

		var_dump($_POST);
	}
?>