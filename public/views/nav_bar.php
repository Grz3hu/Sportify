<nav>
    <div class="nav-logo">
        <img src="public/img/logo_title.svg" >
    </div>
    <?php echo ($currentPage==='add_event' ? '<div class="selected">' : '<div>'); ?>
        <a href=add_event class=nav-button><i class="fa-regular fa-calendar-plus"></i> Add event </a>
    </div>
    <?php echo ($currentPage==='my_events' ? '<div class="selected">' : '<div>'); ?>
    	<a href=my_events class=nav-button><i class="fa-solid fa-calendar-days"></i> My events </a>
    </div>
    <?php echo ($currentPage==='events' ? '<div class="selected">' : '<div>'); ?>
        <?php echo ($currentPage==='events' ? '<a href=events class=nav-button><i class="fa-sharp fa-solid fa-magnifying-glass"></i></a><input id="searchbar" placeholder="Search..">' : '<a href=events class=nav-button><i class="fa-sharp fa-solid fa-magnifying-glass"></i> Search events </a>'); ?>
    </div>
    <div>
        <a href=logout class=nav-button><i class="fa-solid fa-right-from-bracket"></i> Logout </a>
    </div>
</nav>
<div class="popup" onclick="this.style.animation='fade-out 0.3s forwards'"><?php
    if(isset($messages)){
        foreach ($messages as $message) {
            echo $message;
        }
    }
    ?></div>
