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


			
			# Mark the time
            $_POST['created']  = Time::now();
            
            # Hash password
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
            
            # Create a hashed token
            $_POST['token']    = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
            

			
            # Insert the new user    
            DB::instance(DB_NAME)->insert_row('users', $_POST);
            
            # Send them to the login page
            Router::redirect('/users/login');
            
    }


        /*-------------------------------------------------------------------------------------------------
        Display a form so users can login
        -------------------------------------------------------------------------------------------------*/
    public function login() {
    
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
                
                //echo $q;        
                
                # If there was, this will return the token           
                $token = DB::instance(DB_NAME)->select_field($q);
                
                # Success
                if($token) {
                
                        # Don't echo anything to the page before setting this cookie!
                        setcookie('token',$token, strtotime('+1 year'), '/');
                        
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
    public function profile($user_name = NULL) {
                
                # Only logged in users are allowed...
                if(!$this->user) {
                        die('Members only. Click on the link to login or sign up for a free account to Chit Chat.<a href="/users/login">Login</a>');
                }
                
                # Set up the View
                $this->template->content = View::instance('v_users_profile');
                $this->template->title   = "Profile";
                                
                # Pass the data to the View
                $this->template->content->user_name = $user_name;
                
                # Display the view
                echo $this->template;
                                
    }

} # end of the class

