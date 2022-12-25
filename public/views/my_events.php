<!DOCTYPE html>
<head>
	<title>Search events</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
	<link rel="stylesheet" type="text/css" href="public/css/events.css">
	<link rel="stylesheet" type="text/css" href="public/css/event.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/932f8a40c9.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="events-container">
		<nav>
			<div>
				<img src="public/img/logo_title.svg" >
			</div>
			<div>
				<i class="fa-regular fa-calendar-plus"></i>
				<a href=add_event class=nav-button>Add event</a>
			</div>
			<div class=selected>
				<i class="fa-solid fa-calendar-days"></i>
				<a href=my_events class=nav-button>My events</a>
			</div>
			<div>
				<i class="fa-sharp fa-solid fa-magnifying-glass"></i>
				<a href=events class=nav-button>Search events</a>
			</div>
			<div>
				<i class="fa-solid fa-right-from-bracket"></i> 
				<a href=login class=nav-button>Logout</a>
			</div>
		</nav>
		<div class="popup" onclick="this.style.animation='fade-out 0.3s forwards'"><?php 
				if(isset($messages)){
					foreach ($messages as $message) {
						echo $message;
					}
				}
			?></div>
		<main>
			<section class="events">
                <?php foreach ($events as $event): ?>
                    <div class="event">
                        <img src="public/uploads/<?= $event->getPicture(); ?>">
                        <div>
                            <h2><?= $event->getCategory(); ?></h2>
                            <?= $event->getDate(); ?>
                            <p><?= $event->getLocation(); ?></p>
                            <div class="social-section">
                                <i class="fas fa-heart"> 14/22</i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
			</section>
		</main>
	</div>
</body>
