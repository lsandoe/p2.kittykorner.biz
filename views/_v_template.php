<!DOCTYPE html>
<html>
<head>
        <title><?php if(isset($title)) echo $title; ?></title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />        
                                        
        <!-- JS/CSS File we want on every page -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>                                
                                                                                
        <!-- Controller Specific JS/CSS -->
        <link rel="stylesheet" href="/css/sample-app.css" type="text/css">
        <link rel="icon" type="image/png" href="cc.png">
        <?php if(isset($client_files_head)) echo $client_files_head; ?>
                
</head>

<body>        
		<!--this header is linked to go back to home page-->
        <h1><a href="/"><img src="/logo.png" alt="Chit Chat logo">Chit Chat</a></h1>
        <nav>
                <menu>
                                <li><a href='/'><button type="button">Home</button></a></li>
                                
                        <?php if($user): ?>
                                <li><a href='/posts/add'><button type="button">Add Post</button></a></li>
                                <li><a href='/posts/'><button type="button">View Posts</button></a></li>
                                <li><a href='/posts/users'><button type="button">Follow Users</button></a></li>
                                <li><a href='/users/profile'><button type="button">View/Edit Profile</button></a></li>
                                <li><a href='/users/logout'><button type="button">Logout</button></a></li>
                        <?php else: ?>
                                <li><a href='/users/signup'><button type="button">Sign Up</button></a></li>
                                <li><a href='/users/login'><button type="button">Log In</button></a></li>
                        <?php endif; ?>
                </menu>
        </nav>
        
        <?php if($user): ?>
                You are logged in as <?=$user->first_name?> <?=$user->last_name?><br>
        <?php endif; ?>
        
        <br><br>
        
        <?php if(isset($content)) echo $content; ?>

        <?php if(isset($client_files_body)) echo $client_files_body; ?>
</body>
</html>