<section id="content">
    <div class="content__wrapper">
        <div class="content__headline">Categories</div>
        <div class="content__inside">
            <div class="content__row">
                <div class="button popup-form" data-api="categories" data-type="add">Add category</div>
            </div>
            <div class="content__row">
                <input class="content__filter" type="text" placeholder="Category filter (name)">
            </div>
            <div class="content__row">
                <div class="table table-3">
                    <div class="table__header">
                        <div class="table__row">
                            <div class="table__col col--2">Type</div>
                            <div class="table__col col--7">Name</div>
                            <div class="table__col col--3">Products</div>
                        </div>
                    </div>
                    <?php
                        $select = "SELECT *, (SELECT name_category from category as cat2 where cat2.id_category = cat.id_parent) parent from category as cat WHERE cat.id_category > 0 order by cat.id_category, cat.id_parent";
                        $select = $con->query($select);
                        while ($row = $select->fetch_assoc()){

                            $products = "SELECT count(*) from category_product where id_category = $row[id_category]";
                            $products = $con->query($products);
                            $r = $products->fetch_row();

                            $parent = $row['id_parent'] != '0';

                            echo "<a class='table__row filter ".($parent ? "table__row--darker" : "")."' href='categories/$row[id_category]'  data-search='$row[name_category]'>
                                <div class='table__col col--2'>".($parent ? "&nbsp;&nbsp;↳" : $row['type_category'])."</div>
                                <div class='table__col col--7'>".($parent ? $row['parent'].' -> '.$row['name_category'] : $row['name_category'])."</div>
                                <div class='table__col col--3'>$r[0]</div>
                            </a>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
