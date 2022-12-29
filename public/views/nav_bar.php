<nav>
    <div>
        <img src="public/img/logo_title.svg" >
    </div>
    <?php echo ($currentPage==='add_event' ? '<div class="selected">' : '<div>'); ?>
        <i class="fa-regular fa-calendar-plus"></i>
        <a href=add_event class=nav-button>Add event</a>
    </div>
    <?php echo ($currentPage==='my_events' ? '<div class="selected">' : '<div>'); ?>
        <i class="fa-solid fa-calendar-days"></i>
        <a href=my_events class=nav-button>My events</a>
    </div>
    <?php echo ($currentPage==='events' ? '<div class="selected">' : '<div>'); ?>
        <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
        <a href=events class=nav-button>Search events</a>
    </div>
    <div>
        <i class="fa-solid fa-right-from-bracket"></i>
        <a href=logout class=nav-button>Logout</a>
    </div>
</nav>
<div class="popup" onclick="this.style.animation='fade-out 0.3s forwards'"><?php
    if(isset($messages)){
        foreach ($messages as $message) {
            echo $message;
        }
    }
    ?></div>