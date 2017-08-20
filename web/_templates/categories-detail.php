<?php

$select = "SELECT *, (SELECT name_category from category as cat2 where cat2.id_category = cat.id_parent) parent from category as cat WHERE cat.id_category = $detail";
$select = $con->query($select);
$row = $select->fetch_assoc();

$connections = "SELECT * from category_product where id_category = $detail";
$connections = $con->query($connections);
$connectionArray = array();

while ($r = $connections->fetch_row()){
    array_push($connectionArray, $r[2]);
}

?>

<section id="content">
    <div class="content__wrapper"><a href="/categories" class="link-back">← Back to category list</a>
        <div class="content__headline"><?php echo (strlen($row['parent']) > 0 ? $row['parent'].' -> ' : '').$row['name_category'] ?></div>
        <div class="content__inside">
            <div class="content__row content__row--header">
                <div class="content__column content__column--6">
                    <div class="label">Category name</div>
                    <input class="input post-value" data-column="name_category" id="name" type="text" placeholder="Category name" value="<?php echo $row['name_category'] ?>">
                </div>
            </div>
            <div class="content__row">
                <div class="label">Products</div>
                <div class="select">
                    <select class="post-value" data-custom="category_product" multiple="multiple" style="width: 100%;">
                        <?php
                            $products = "SELECT id_product, PRODUCTNAME from products order by PRODUCTNAME asc";
                            $products = $con->query($products);
                            while ($r = $products->fetch_row()){
                                echo "<option value='$r[0]' ".(in_array($r[0], $connectionArray) ? "selected" : '').">$r[1]</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="content__row">
                <div class="button button--confirm button--post" data-post-id="<?php echo "id_category=".$detail; ?>" data-id="<?php echo $detail; ?>" data-api="categories">Save changes</div>
                <div class="button button--cancel button--delete" data-delete-id="<?php echo "id_category=".$detail; ?>" data-api="categories" data-popup-header="Category deletion" data-popup-button="Delete category" data-popup-content="Do you really want to delete this category and all its child categories?">Delete category</div>
            </div>
        </div>
    </div>
</section>
