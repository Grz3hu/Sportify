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
        <?php $currentPage='my_events'; include('nav_bar.php') ?>
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
                                <i class="fas fa-heart"> <?= $event->getLikes(); ?></i>
                                <i class="fas fa-minus-square"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
			</section>
		</main>
	</div>
</body>
