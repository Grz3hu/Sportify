<!DOCTYPE html>
<head>
	<title>Search events</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
	<link rel="stylesheet" type="text/css" href="public/css/events.css">
	<link rel="stylesheet" type="text/css" href="public/css/event.css">
    <script type="text/javascript" src="public/js/search.js" defer></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/932f8a40c9.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="events-container">
        <?php $currentPage='events'; include('nav_bar.php') ?>
		<main>
            <input id="searchbar-mobile" placeholder="Search..">
			<section class="events">
                <?php foreach ($events as $event): ?>
				    <div class="event">
				    	<img src="public/uploads/<?= $event->getPicture(); ?>">
				    	<div>
				    		<h2><?= $event->getCategory(); ?></h2>
                            <div id="date"><?= $event->getDate(); ?></div>
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

<template id="event-template">
    <div class="event">
        <img src="">
        <div>
            <h2>category</h2>
            <div id="date">date</div>
            <p>location</p>
            <div class="social-section">
                <i class="fas fa-heart"> 14/22</i>
            </div>
        </div>
    </div>
</template>
