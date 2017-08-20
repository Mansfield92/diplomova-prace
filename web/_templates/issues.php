<section id="content">
    <div class="content__wrapper">
        <div class="content__headline">Issues</div>
        <div class="content__inside">
            <div class="content__row">
                <div class="button popup-form" data-api="problems" data-type="add">Add issue</div>
            </div>
            <div class="content__row">
                <input class="content__filter" type="text" placeholder="Issue filter">
            </div>
            <div class="content__row">
                <div class="table table-3">
                    <div class="table__header">
                        <div class="table__row">
                            <div class="table__col col--8">Name</div>
                            <div class="table__col col--2">Pool</div>
                            <div class="table__col col--2">Whirlpool</div>
                        </div>
                    </div>

                    <?php
                    $select = "SELECT * from problem left join translations using(id_problem) GROUP By problem.id_problem ORDER BY header asc";
                    $select = $con->query($select);
                    while ($row = $select->fetch_assoc()){
                        $pool = ($row['pool'] == '1' ? '<span class="green">Yes</span>' : '<span class="red">No</span>');
                        $whirlpool = ($row['whirlpool'] == '1' ? '<span class="green">Yes</span>' : '<span class="red">No</span>');

                        echo "<a class='table__row filter' href='/issues/$row[id_problem]'  data-search='$row[header]'>
                                <div class='table__col col--8'>$row[header]</div>
                                <div class='table__col col--2'>$pool</div>
                                <div class='table__col col--2'>$whirlpool</div>
                            </a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
