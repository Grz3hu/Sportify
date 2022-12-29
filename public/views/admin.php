<!DOCTYPE html>
<head>
	<title>Search events</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
	<link rel="stylesheet" type="text/css" href="public/css/events.css">
	<link rel="stylesheet" type="text/css" href="public/css/event.css">
    <link rel="stylesheet" type="text/css" href="public/css/admin.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/932f8a40c9.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="users-container">
    <?php include('nav_bar.php') ?>
    <table>
        <tr>
            <th>name</th>
            <th>email</th>
            <th>phone_number</th>
            <th>profile_picture</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->getName(); ?></td>
            <td><?= $user->getEmail(); ?></td>
            <td><?= $user->getPhoneNumber(); ?></td>
            <td><?= $user->getProfilePic(); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
</body>
