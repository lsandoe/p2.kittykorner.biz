
    
    <!-- first check if the user is logged in before we show the profile information -->
<?php if(isset($user->first_name)): ?>
        <h1>This is the profile for <?=$user->first_name?> <?=$user->last_name?></h1>
<?php else: ?>
        <h1>No user has been specified</h1>
<?php endif; ?>

<form method='POST' action='/users/p_update_user_profile'>

        First Name <input type='text' name='first_name' value=<?=$user->first_name?> /><br>
        Last Name <input type='text' name='last_name' value=<?=$user->last_name?> /><br>
        Email <input type='text' name='email' value=<?=$user->email?> /><br>
        <!-- call to run reset password -->
        Password <a href="/users/password_reset"><button type="button">Press to Reset Password</button></a><br>
        Location <input type='text' name='location' value=<?=$user->location?> /><br>
        Short Bio <textarea name='bio' rows='5' cols='82'><?=$user->bio?></textarea><br>
        
        <input type='submit' value='Update'>
        

</form>
