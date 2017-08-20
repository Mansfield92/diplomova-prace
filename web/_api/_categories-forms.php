<?php
$post = (string)file_get_contents('php://input');
$data = json_decode($post, true);

$return = array();
    switch ($data['form']){
        case 'add':

            $categoryOptions = '<option></option>';
            $categories = "SELECT * from category where id_parent = 0";
            $categories = $con->query($categories);
            while ($cat = $categories->fetch_assoc()){
                $type = $cat['type_category'];
                $type = strlen($type) > 1 ? $type : false;
                $categoryOptions .= "<option value='$cat[id_category]'>$cat[name_category]".($type ? " ($type)" : '')."</option>";
            }
//

            $return['header'] = 'Add category';
            $return['button'] = '<div class="button button--confirm button--put" data-api="categories">Ok</div>';
            $return['content'] =
                '<div class="popup__form__row">
                    <div class="popup__form__item__label">Category name</div>
                    <input class="hidden put-value" value="NULL" data-column="id_category" type="text">
                    <input class="input put-value" data-column="name_category" id="name" type="text" placeholder="Category name">
                </div>
                <div class="popup__form__row">
                    <div class="popup__form__item__label">Parent category</div>
                    <div class="select">
                        <select class="put-value category-select custom-select" data-action="type_category" data-column="id_parent" style="width: 100%;">
                            '.$categoryOptions.'
                        </select>
                    </div>
                </div>
                <div class="popup__form__row hidden category-type">
                    <div class="popup__form__item__label">Category type</div>
                    <div class="radiogroup radiogroup">
                        <div class="radiogroup__item">
                            <input checked="checked" class="radio put-value category-type" value="pool" data-column="type_category" type="radio" name="category-radio" id="radio-1">
                            <label for="radio-1">Pool</label>
                        </div>
                        <div class="radiogroup__item">
                            <input class="radio input--edit" value="whirlpool" type="radio" name="category-radio" id="radio-2">
                            <label for="radio-2">Whirlpool</label>
                        </div>
                    </div>
                </div>';
            break;
    }

echo json_encode($return);


