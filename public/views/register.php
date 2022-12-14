<!DOCTYPE html>
<head>
	<title>Register</title>
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
			<div class="register-container">
				<form action="register" method="POST" ENCTYPE="multipart/form-data">
					<div class="popup" onclick="this.style.animation='fade-out 0.3s forwards'"><?php 
							if(isset($messages)){
								foreach ($messages as $message) {
									echo $message;
								}
							}
					?></div>
					<input name="name" type="text" placeholder="name">
					<input name="phone_number" type="text" placeholder="phone number">
					<input name="email" type="email" placeholder="email@example.com">
					<input name="password" type="password" placeholder="password">
					<input name="password2" type="password" placeholder="repeat password">
					<div class="file-input">
						<input name="profile_pic" class="file" id="file" type="file" accept="image/png, image/jpeg">
						<label for="file">profile picture</label>
					</div>
					<button type="submit" class="register-button">Register</button>
					<button type="button" onclick="location.href='login';" id="login">Login</button>
				</form>
			</div>
	</div>
</body>
