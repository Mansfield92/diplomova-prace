<nav class="navbar">
    <div class="container--fluid">
        <ul class="nav navbar-nav navbar-right">
            <div class="profile">
                <a class="profile-toggle" href="#">profile <span class="light-blue"> - <?php echo $user['fullname']; ?></span></a>
                <ul class="profile__content">
<!--                    <li class="profile__img"><img class="profile-img" src="/img/avatars/profile.jpg"></li>-->
                    <li>
                        <div class="profile__info">
                            <h4 class="username">nickname - <?php echo $user['nickname']; ?></h4>
                            <div class="button button--password" data-id="<?php echo $user['id']; ?>" >Change password</div>
                            <div class="button button--ico logout"><i class="fa fa-sign-out">Logout</i></button>
                        </div>
                    </li>
                </ul>
            </div>
        </ul>
    </div>
</nav>
