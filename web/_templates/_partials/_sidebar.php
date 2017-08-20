<div class="sidebar">

    <div class="navbar-expand-toggle"><i class="fa fa-bars icon closed"></i><i class="fa fa-close icon opened"></i></div>
    <div class="sidebar__header"><a class="sidebar__brand" href="/"><span class="icon fa fa-paper-plane"></span>
            <div class="sidebar__title">Admin</div></a>
        <nav class="navigation">
            <li class="navigation__item <?php echo ($page == 'categories' ? ' active' : '') ?>"><a href="/categories"><span class="icon fa fa-list"></span><span class="navigation__item__title">Categories</span></a></li>
            <li class="navigation__item <?php echo ($page == 'products' ? ' active' : '') ?>"><a href="/products"><span class="icon fa fa-cube"></span><span class="navigation__item__title">Products</span></a></li>
            <li class="navigation__item <?php echo ($page == 'issues' ? ' active' : '') ?>"><a href="/issues"><span class="icon fa fa-warning"></span><span class="navigation__item__title">Issues</span></a></li>
            <li class="navigation__item <?php echo ($page == 'testapi' ? ' active' : '') ?>"><a href="/testapi"><span class="icon fa fa-desktop"></span><span class="navigation__item__title">External API preview</span></a></li>
            <li class="navigation__item <?php echo ($page == 'xml' ? ' active' : '') ?>"><a href="/xml"><span class="icon fa fa-desktop"></span><span class="navigation__item__title">XML feed</span></a></li>
            <?php if($user['level'] > 1):?>
                <li class="navigation__item <?php echo ($page == 'users' ? ' active' : '') ?>"><a href="/users"><span class="icon fa fa-user"></span><span class="navigation__item__title">Users</span></a></li>
            <?php endif;?>
        </nav>
    </div>
</div>
