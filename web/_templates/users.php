<?php if($user['level'] > 1):?>
<section id="content">
    <div class="content__wrapper">
        <div class="content__headline">Users</div>
        <div class="content__inside">
            <div class="content__row">
                <input class="content__filter" type="text" placeholder="User filter">
            </div>
            <div class="content__row">
                <div class="table">
                    <div class="table__header">
                        <div class="table__row">
                            <div class="table__col col--4">Nick</div>
                            <div class="table__col col--4">Full name</div>
                            <div class="table__col col--2">Level</div>
                            <div class="table__col col--2">Active</div>
                        </div>
                    </div>

                    <?php
                    $select = "SELECT * FROM users where nickname != '$user[nickname]'";
                    $select = $con->query($select);
                    while ($row = $select->fetch_assoc()) {
                        $active = ($row['active'] == '1' ? '<span class="green">Yes</span>' : '<span class="red">No</span>');
                        echo '<a class="table__row filter" href="/users/' . $row['id'] . '" data-search="' . $row['nickname'] . $row['fullname'] . '">
                        <div class="table__col col--4">' . $row['nickname'] . '</div>
                        <div class="table__col col--4">' . $row['fullname'] . '</div>
                        <div class="table__col col--2">' . $row['level'] . '</div>
                        <div class="table__col col--2">'.$active.'</div>
                        </a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php else:  ?>

<section id="content">
    <div class="content__wrapper">
        You don't have permissions to access this page!
    </div>
</section>


<?php endif; ?>
