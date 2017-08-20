<?php

$select = "SELECT * FROM users WHERE id = $detail";
$select = $con->query($select);
$row = $select->fetch_assoc();

?>

<?php if($user['level'] > 1):?>

<section id="content">
    <div class="content__wrapper"><a href="/users" class="link-back">← Back to list of users</a>
        <div class="content__headline"><?php echo $row['fullname']; ?></div>
        <div class="content__inside">
            <div class="content__row content__row--header">
                <div class="content__column content__column--6">
                    <div class="label">Full name</div>
                    <div class="value"><?php echo $row['fullname'] ?></div>
                </div>
                <div class="content__column content__column--6">
                    <div class="label">Nick</div>
                    <div class="value"><?php echo $row['nickname'] ?></div>
                </div>
            </div>
            <div class="content__row">
                <div class="content__column content__column--6">
                    <div class="label">Active</div>
                    <div class="radiogroup radiogroup">
                        <div class="radiogroup__item">
                            <input class="radio post-value" value="1" data-column="active" type="radio" name="radio-1" id="radio-1" <?php echo ($row['active'] == '1' ? 'checked="true"' : '') ?>>
                            <label for="radio-1">Yes</label>
                        </div>
                        <div class="radiogroup__item">
                            <input class="radio input--edit" value="0" type="radio" name="radio-1" id="radio-2" <?php echo ($row['active'] == '0' ? 'checked="true"' : '') ?>>
                            <label for="radio-2">No</label>
                        </div>
                    </div>
                </div>

                <div class="content__column content__column--6">
                    <div class="label">Permission level</div>
                    <input class="input post-value" data-column="level" id="level" type="text" placeholder="Level" value="<?php echo $row['level'] ?>">
                </div>
            </div>
            <div class="content__row">
                <div class="button button--confirm button--post" data-post-id="<?php echo "id=".$detail; ?>" data-id="<?php echo $detail; ?>" data-api="users">Save changes</div>
                <div class="button button--cancel button--delete" data-delete-id="<?php echo "id=".$detail; ?>" data-api="users" data-popup-header="Delete user" data-popup-button="Delete"
                     data-popup-content="Do you really want to delete this user?">Delete user</div>
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
