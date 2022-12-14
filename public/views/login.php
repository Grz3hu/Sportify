<!DOCTYPE html>
<head>
	<title>Login Page</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="logo">
			<img src="public/img/logo_title.svg" >
		</div>
		<div class="login-container">
			<form action="login" method="POST">
				<div class="popup" onclick="this.style.animation='fade-out 0.3s forwards'"><?php 
						if(isset($messages)){
							foreach ($messages as $message) {
								echo $message;
							}
						}
				?></div>
				<input name="email" type="email" placeholder="email@example.com">
				<input name="password" type="password" placeholder="password">
				<button type="submit">Login</button>
				<button type="button" onclick="location.href='register';" class="register-button">Register</button>
			</form>
		</div>
	</div>
</body>
