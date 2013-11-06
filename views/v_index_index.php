<?php if($user): ?>
 
 		<pre>
        	<?php
        		print_r($user);
			?>	
        </pre>
        Hello <?=$user->first_name;?>
<?php else: ?>
        Welcome Chit Chatter!<br>
		This is a chatting blog to not only chat with others, but follow what they are up to as well.  So lets get started and become part of the chatting network!      
<?php endif; ?>