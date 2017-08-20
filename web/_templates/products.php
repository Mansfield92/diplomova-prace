<section id="content">
    <div class="content__wrapper">
        <div class="content__headline">Products</div>
        <div class="content__inside">
            <div class="content__row">
                <input class="content__filter" type="text" placeholder="Product filter (name, ID, listed)">
            </div>
            <div class="content__row">
                <div class="table table-3">
                    <div class="table__header">
                        <div class="table__row">
                            <div class="table__col col--2">ID</div>
                            <div class="table__col col--6">Name</div>
                            <div class="table__col col--2">Price</div>
                            <div class="table__col col--2">Listed</div>
                        </div>
                    </div>

                    <?php
                    $select = "SELECT * from products order by PRODUCTNAME asc";
                    $select = $con->query($select);
                    while ($row = $select->fetch_assoc()){

                        $q = "SELECT * from category_product WHERE id_product = $row[id_product]";
                        echo $q;
                        $listed = $con->query($q);
                        $listed = $listed->num_rows > 0;

                        $l = ($listed ? '<span class="green">Yes</span>' : '<span class="red">No</span>');

                        echo "<a class='table__row filter' href='/products/$row[ITEM_ID]'  data-search='$row[PRODUCTNAME] $row[ITEM_ID] ".($listed ? 'Yes' : 'No')."'>
                                <div class='table__col col--2'>$row[ITEM_ID]</div>
                                <div class='table__col col--6'>$row[PRODUCTNAME]</div>
                                <div class='table__col col--2'>$row[PRICE_VAT] Kč</div>
                                <div class='table__col col--2'>$l</div>
                            </a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
