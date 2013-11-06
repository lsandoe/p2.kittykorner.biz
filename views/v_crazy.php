
    
    <!-- first check if the user is logged in before we show the profile information -->
<?php if(isset($user->first_name)): ?>
        <h1><?=$user->first_name?> <?=$user->last_name?> , your profile is shown below and is ready for you to edit.</h1>
<?php else: ?>
        <h1>No user has been specified</h1>
<?php endif; ?>

<form method='POST' action='/users/p_update_user_profile'>

        First Name <input type='text' name='first_name' value=<?=$user->first_name?> /><br /><br />
        Last Name <input type='text' name='last_name' value=<?=$user->last_name?> /><br /><br />
        Email <input type='text' name='email' value=<?=$user->email?> /><br /><br />
        <!-- call to run reset password -->
        Password <input type='text' name='password' value='Type in a new password'/><br /><br />
        Location <input type='text' name='location' value=<?=$user->location?> /><br /><br />
        A Short Biography is presented below <br> <textarea name='bio' rows='5' cols='82'><?=$user->bio?></textarea><br />
        <br />
        <input type='submit' value='Update My Profile'>
        <!-- give the user a way to just say everything is okay-->

        <a href="/" ><button type="button">Everything Looks Okay With Me</button></a>
        
        

</form>
