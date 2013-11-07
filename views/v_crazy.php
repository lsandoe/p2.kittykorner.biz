
    
    <!-- first check if the user is logged in before we show the profile information -->
<?php if(isset($user->first_name)): ?>
        <h1><?=$user->first_name?> <?=$user->last_name?> , your profile is shown below and is ready for you to edit.</h1>
<?php else: ?>
        <h1>No user has been specified</h1>
<?php endif; ?>

<form method='POST' action='/users/p_update_user_profile'>

        First Name: <?=$user->first_name?> <input type='text' name='first_name' /><br /><br />
        Last Name: <?=$user->last_name?> <input type='text' name='last_name' /><br /><br />
       <!-- Email: <?=$user->email?> <input type='text' name='email' /><br /><br />-->
        <!-- call to run reset password -->
        Password: <input type='text' name='password' value='Type in a new password'/><br /><br />
        Location: <?=$user->location?> <input type='text' name='location' /><br /><br />
        A Short Biography is presented below <br> <?=$user->bio?> <br> <textarea name='bio' rows='5' cols='82'></textarea><br />
        <br />
        <input type='submit' value='Update My Profile'>
        <!-- give the user a way to just say everything is okay-->

        <a href="/" ><button type="button">Everything Looks Okay With Me</button></a>
        
        

</form>
