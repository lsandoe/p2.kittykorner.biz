<!--first check if the user is signed in-->
<?php if($user): ?>
        <!-- Greet the signed up user-->
        Hello <?=$user->first_name . " " . $user->last_name ?>
<?php else: ?>
		<!-- Explain to the new arrival what this is all about-->
        <h3>Welcome Chit Chatter!</h3>
		<p>This is a chatting blog to not only chat with others, but follow what they are up to throughout the day.  So lets get started by signing up or signing in to become part of the chatting network!</p>      
<?php endif; ?>