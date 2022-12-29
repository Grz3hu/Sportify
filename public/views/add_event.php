<!DOCTYPE html>
<head>
    <title>Add Event</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/events.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/932f8a40c9.js" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYdiEfgAVjWt0w7BBj2yS2EY1BMom5wkQ&libraries=places"></script>
    <script>
        function initialize() {
            var input = document.getElementById('location');
            new google.maps.places.Autocomplete(input);
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>
<body>
<div class="events-container">
    <?php $currentPage='add_event'; include('nav_bar.php') ?>
    <div class="add-event-container">
        <form action="add_event" method="POST" ENCTYPE="multipart/form-data">
            <input name="category" type="text" placeholder="choose sport">
            <input name="date" type="date" placeholder="choose when">
            <input name="location" id="location" type="text" placeholder="choose location">
            <div class="file-input">
                <input name="event_photo" class="file" id="file" type="file" accept="image/png, image/jpeg">
                <label for="file">upload picture</label>
            </div>
            <div class="event-buttons-container">
                <button type="submit">Add</button>
                <button type="button" onclick="history.back()">Back</button>
            </div>
        </form>
    </div>
</body>
