<?php
class users_controller extends base_controller {
/*-------------------------------------------------------------------------------------------------
        
-------------------------------------------------------------------------------------------------*/
    public function __construct() {
    
            # Make sure the base controller construct gets called
            parent::__construct();
    } 
/*-------------------------------------------------------------------------------------------------
        Display a form so users can sign up        
-------------------------------------------------------------------------------------------------*/
    public function signup() {
       # Set up the view
       $this->template->content = View::instance('v_users_signup');
       
       # Render the view
       echo $this->template;
    }
/*-------------------------------------------------------------------------------------------------
    Process the sign up form
-------------------------------------------------------------------------------------------------*/
    public function p_signup() {
			# set up an sql statement that needs to be sanitized to check for duplicate email mddresses
			# sanitize the user input
			
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);
			$q = "SELECT email FROM users WHERE email = '" . $_POST['email'] . "'"; 
			
			# execute the query			
			$possibleDuplicateEmail = DB::instance(DB_NAME)->select_field($q);
			
			#echo " The post email is " . $_POST[email] . " the possible db email is " . $possibleDuplicateEmail;
			# check to see if the email being entered has already been added to the users table 
			# if the email address has already been submitted then return to the form and let the user know to pick another valid email
			if ($possibleDuplicateEmail == $_POST['email']) {
				#echo "fine return to the signup page with a pick another email address message";
				
				#call a Duplicate Email Redo sign up view so the user can re-enter information and another valid email address
				# Set up the view
       			$this->template->content = View::instance('v_users_signup_enter_a_new_email');
       
       			# Render the view
       			echo $this->template;
			} else {
				
				# Mark the time
				$_POST['created']  = Time::now();
				
				# Mark the time
				$_POST['modified']  = Time::now();
				
				# Hash password
				$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
				
				# Create a hashed token
				$_POST['token']    = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
				
				# Insert the new user    
				DB::instance(DB_NAME)->insert_row('users', $_POST);
				
				Router::redirect('/users/login/');
			}
    }
/*-------------------------------------------------------------------------------------------------
        Display a form so users can login
-------------------------------------------------------------------------------------------------*/
    public function login($user_id = NULL) {
            $this->template->content = View::instance('v_users_login');            
            echo $this->template;
    }
/*-------------------------------------------------------------------------------------------------
    Process the login form
-------------------------------------------------------------------------------------------------*/
    public function p_login() {
                   # Hash the password they entered so we can compare it with the ones in the database
                $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
                
                # Set up the query to see if there's a matching email/password in the DB
                $q = 
                        'SELECT token 
                        FROM users
                        WHERE email = "'.$_POST['email'].'"
                        AND password = "'.$_POST['password'].'"';
                
                # If there was, this will return the token           
                $token = DB::instance(DB_NAME)->select_field($q);
				
                # Success
                if($token) {
                
                        # Don't echo anything to the page before setting this cookie!
                        setcookie('token',$token, strtotime('+1 year'), '/');
                        
						 $logintime = Time::now();
						
						# set the alst login time
						
						$sql = "UPDATE users SET last_login=" .  $logintime . " WHERE token='" . $token . "'";
	
						
						DB::instance(DB_NAME)->query($sql);
						
						
                        # Send them to the homepage
                        Router::redirect('/');
                }
                # Fail
                else {
                        echo "Login failed! <a href='/users/login'>Try again?</a>";
                }
    }
/*-------------------------------------------------------------------------------------------------
        No view needed here, they just goto /users/logout, it logs them out and sends them
        back to the homepage.        
-------------------------------------------------------------------------------------------------*/
    public function logout() {
       
       # Generate a new token they'll use next time they login
       $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
       
       # Update their row in the DB with the new token
       $data = Array(
               'token' => $new_token
       );
       DB::instance(DB_NAME)->update('users',$data, 'WHERE user_id ='. $this->user->user_id);
       
       # Delete their old token cookie by expiring it
       setcookie('token', '', strtotime('-1 year'), '/');
       
       # Send them back to the homepage
       Router::redirect('/');
    }
/*-------------------------------------------------------------------------------------------------
        
-------------------------------------------------------------------------------------------------*/
   public function profile() {
                # Set up the View
                $this->template->content = View::instance('v_crazy');

				# Pass the data to the View
                $this->template->content->user_name = $user_name;
				
                # Display the view
                echo $this->template;
    }
/*-------------------------------------------------------------------------------------------------
        
-------------------------------------------------------------------------------------------------*/
	public function p_update_user_profile() {
		   
		   		# Since the form has accepted user input, this needs to be sanitized
				$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		   
		   		# Update the time user profile was last modified
            	$_POST['modified']  = Time::now();
			
				# check if password is blank or set to the default of 'Type in a new password.' 
				#If so then use the unset method for the $_POST
				if (($_POST[password] == "") or ($_POST[password] == 'Type in a new password')) {
					
					# get rid of the password field in the $_POST object because the user did not
					# enter a password or left it blank
					unset($_POST[password]);
					
					# Build a SQL query without the password at all since the user
					# entered nothing or cleared the field alltogether
					$sql = "UPDATE users SET 
					modified=" . $_POST[modified] . ", 
					first_name='" . $_POST[first_name] . "', 
					last_name='" . $_POST[last_name] . "', 
					location='" . $_POST[location] . "', 
					bio='" . $_POST[bio] . "' 
					WHERE user_id =" . $_POST[userid] . "";
				} else {
					# Hash password
					$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
					
					# Build a SQL string that will also update the password
					$sql = "UPDATE users SET 
					modified=" . $_POST[modified] . ", 
					password='" . $_POST[password] . "', 
					first_name='" . $_POST[first_name] . "', 
					last_name='" . $_POST[last_name] . "', 
					location='" . $_POST[location] . "', 
					bio='" . $_POST[bio] . "' 
					WHERE user_id =" . $_POST[userid] . "";
				}
				
				# Executing an Update Query to revise the user profile
				DB::instance(DB_NAME)->query($sql);
	  
            	# Send them to the login page
            	Router::redirect('/');
    }
/*-------------------------------------------------------------------------------------------------
	This is the end of all the functions in the users controller
-------------------------------------------------------------------------------------------------*/
} # end of the class

