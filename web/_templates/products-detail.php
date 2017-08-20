<?php

$select = "SELECT * FROM products WHERE ITEM_ID = '$detail'";
$select = $con->query($select);
$row = $select->fetch_assoc();

'Units, Size in units, 
Objem vody (v m3), na který je určeno celé balení:
Interval dávkování (dny): 
O kolik se změní hodnota stavu ph při aplikování jedné dávky:'


?>

<section id="content" class="products">
    <div class="content__wrapper"><a href="/products" class="link-back">← Back to list of products</a>
        <div class="content__headline"><?php echo $row['PRODUCTNAME'] ?></div>
        <div class="content__inside">
            <div class="content__row">
                <div class="content__column content__column--6">
                    <div class="label">ID</div>
                    <div class="value"><?php echo $row['ITEM_ID'] ?></div>
                </div>
                <div class="content__column content__column--6">
                    <div class="label">Price</div>
                    <div class="value"><?php echo $row['PRICE_VAT'] ?> Kč</div>
                </div>
            </div>
            <div class="content__row">
                <div class="content__column content__column--12 content__column--accordion">
                    <div class="label">Description</div>
                    <div class="value"><?php echo htmlspecialchars_decode($row['DESCRIPTION']); ?></div>
                </div>
            </div>
            <div class="content__row  content__row--header">
                <div class="content__column content__column--6">
                    <div class="label">ID</div>
                    <div class="value"><?php echo $row['ITEM_ID'] ?></div>
                </div>
                <div class="content__column content__column--6">
                    <div class="label">Price</div>
                    <div class="value"><?php echo $row['PRICE_VAT'] ?> Kč</div>
                </div>
            </div>
            <div class="content__row">
                <div class="content__column content__column--6">
                    <div class="label">Units</div>
                    <div class="select">
                        <select class="post-value custom-select" data-column="material" style="width: 100%;">
                            <?php

                            $units = "SELECT * from units order by name_unit asc";
                            $units = $con->query($units);
                            while ($r = $units->fetch_assoc()){
                                echo "<option value='$r[id_unit]' ".($r['id_unit'] == $row['material'] ? "selected" : '').">$r[name_unit] ($r[shotcut])</option>";
                            }

                            ?>
                        </select>
                    </div>
                </div>
                <div class="content__column content__column--6">
                    <div class="label">Size in units</div>
                    <input class="input post-value" data-column="baleni" id="baleni" type="text" placeholder="Size in units" value="<?php echo $row['baleni'] ?>">
                </div>
            </div>
            <div class="content__row">
                <div class="content__column content__column--6">
                    <div class="label">Volume of water [m<sup>3</sup>] you can cover with whole package</div>
                    <input class="input post-value" data-column="davkovani" id="davkovani" type="text" placeholder="Volume" value="<?php echo $row['davkovani'] ?>">
                </div>
                <div class="content__column content__column--6">
                    <div class="label">Interval of application [days]</div>
                    <input class="input post-value" data-column="interval_" id="interval_" type="text" placeholder="Interval" value="<?php echo $row['interval_'] ?>">
                </div>
            </div>
            <div class="content__row">
                <div class="content__column content__column--6">
                    <div class="label">Change of PH with one dose</div>
                    <input class="input post-value" data-column="efficiency" id="efficiency" type="text" placeholder="PH change" value="<?php echo $row['efficiency'] ?>">
                </div>
            </div>
            <div class="content__row">
                <div class="button button--confirm button--post" data-post-id="<?php echo " ITEM_ID='$detail'"; ?>" data-id="<?php echo $detail; ?>" data-api="products">Save changes</div>
                <div class="button button--cancel button--delete" data-delete-id="<?php echo " ITEM_ID='$detail'"; ?>" data-api="products" data-popup-header="Product deletion" data-popup-button="Delete product" data-popup-content="Do you really want to delete this product?">Delete product</div>

            </div>
        </div>
    </div>
</section>
