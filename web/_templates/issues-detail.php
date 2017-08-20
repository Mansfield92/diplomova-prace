<?php

$select = "SELECT * FROM problem WHERE id_problem = '$detail'";
$select = $con->query($select);
$row = $select->fetch_assoc();

$connections = "SELECT * from problem_category where id_problem = $detail";
$connections = $con->query($connections);
$connectionArray = array();

while ($r = $connections->fetch_row()){
    array_push($connectionArray, $r[0]);
}

$translations = $con->query("SELECT * from translations where id_problem = $detail");

?>

<section id="content">
    <div class="content__wrapper"><a class="link-back" href="/issues">← Back to issues</a>
        <div class="content__inside">
            <div class="content__row">
                <div class="label">Translations</div>
                <div class="tabs">
                    <div class="tabs__nav">
                        <div class="active tabs__nav__item" data-toggle="tab-1">CS</div>
                        <div class="tabs__nav__item" data-toggle="tab-2">EN</div>
                        <div class="tabs__nav__item" data-toggle="tab-3">DE</div>
                        <div class="tabs__nav__item" data-toggle="tab-4">RU</div>
                    </div>

                    <?php
                        for($i = 1; $i <=$translations->num_rows; $i++){

                            $tran = $translations->fetch_assoc();

                            ?>

                            <div class="tab post-value <?php echo ($i == 1 ? 'active' : ''); ?>" data-custom="problem_translations" data-lang="<?php echo $tran['lang']; ?>"  id="tab-<?php echo $i; ?>">
                                <div class="tab__content">
                                    <div class="content__row">
                                        <div class="content__column content__column--6">
                                            <div class="label">Name</div>
                                            <input class="input" value="<?php echo $tran['header']; ?>" data-column="header" data-lang="<?php echo $tran['lang']; ?>" type="text" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="content__row">
                                        <div class="content__column content__column--12">
                                            <div class="label">Description</div>
                                            <textarea class="input" data-column="content" data-lang="cs" type="text" placeholder="Description"><?php echo $tran['content']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php

                        }
                    ?>
                </div>
            </div>
            <div class="content__row content__row--header">
                <div class="content__column content__column--6">
                    <div class="label">Chlorine</div>
                    <div class="radiogroup radiogroup">
                        <div class="radiogroup__item">
                            <input class="radio post-value" data-column="chlorine" type="radio" value="1" name="radio-1" id="radio-1" <?php echo ($row['chlorine'] == '1' ? 'checked="true"' : '') ?>>
                            <label for="radio-1">Yes</label>
                        </div>
                        <div class="radiogroup__item">
                            <input class="radio input--edit" type="radio" value="0" name="radio-1" id="radio-2"  <?php echo ($row['chlorine'] == '0' ? 'checked="true"' : '') ?>>
                            <label for="radio-2">No</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content__row">
                <div class="label">Properties</div>
                <div class="radiogroup radiogroup">
                    <div class="radiogroup__item">
                        <input class="checkbox post-value" data-column="ph" type="checkbox" name="checkbox-1" id="checkbox-1" <?php echo ($row['ph'] == '1' ? 'checked="true"' : '') ?>>
                        <label for="checkbox-1">is PH needed?</label>
                    </div>
                    <div class="radiogroup__item">
                        <input class="checkbox  post-value" data-column="pool" type="checkbox" name="checkbox-2" id="checkbox-2" <?php echo ($row['pool'] == '1' ? 'checked="true"' : '') ?>>
                        <label for="checkbox-2">for Pools</label>
                    </div>
                    <div class="radiogroup__item">
                        <input class="checkbox  post-value" data-column="whirlpool" type="checkbox" name="checkbox-3" id="checkbox-3" <?php echo ($row['whirlpool'] == '1' ? 'checked="true"' : '') ?>>
                        <label for="checkbox-3">for Whirlpools</label>
                    </div>
                </div>
            </div>
            <div class="content__row">
                <div class="label">Categories</div>

                <div class="select">
                    <select class="post-value" data-custom="problem_category" multiple="multiple" style="width: 100%;">
                        <?php
                        $products = "SELECT id_category, name_category, type_category from category where id_category > 0 order by name_category asc";
                        $products = $con->query($products);
                        while ($r = $products->fetch_row()){
                            echo "<option value='$r[0]' ".(in_array($r[0], $connectionArray) ? "selected" : '').">$r[1] ($r[2])</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="content__row">
                <div class="button button--confirm button--post" data-post-id="<?php echo "id_problem=".$detail; ?>" data-id="<?php echo $detail; ?>" data-api="problems">Save changes</div>
                <div class="button button--cancel button--delete" data-delete-id="<?php echo "id_problem=".$detail; ?>" data-api="problems" data-popup-header="Delete issue" data-popup-button="Delete issue" data-popup-content="Do you really want to delete this issue?">Delete issue</div>
            </div>
        </div>
    </div>
</section>
