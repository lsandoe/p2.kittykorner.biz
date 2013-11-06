<?php

class practice_controller extends base_controller {
	

	public function test_db() {
		/*$q = "UPDATE users
		SET email = 'albert@aol.com'
		WHERE first_name = 'albert'"; 
		
		
		
		
		
		/*"INSERT INTO users SET 
		first_name = 'Albert',
		last_name = 'Einstein'";
	    */
		
		
		$new_user = Array(
		first_name => 'albert',
		last_name => 'einstein',
		email => 'albert@gmail.com',);
		
		
	echo $q; 
	
		
	DB::instance(DB_NAME)->insert('users', $new_user);	
			
	}
	
} # eoc

?>