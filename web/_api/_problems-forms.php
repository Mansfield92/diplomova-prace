<?php
$post = (string)file_get_contents('php://input');
$data = json_decode($post, true);

$return = array();
switch ($data['form']){
    case 'add':

        $return['header'] = 'Add issue';
        $return['button'] = '<div class="button button--confirm button--put" data-api="problems">Ok</div>';
        $return['content'] =
            '<div class="popup__form__row">

                    <input class="hidden put-value" value="NULL" data-column="id_problem" type="text">
                    <div class="label">Chlorine</div>
                    <div class="radiogroup radiogroup">
                        <div class="radiogroup__item">
                            <input class="radio put-value" data-column="chlorine" type="radio" value="1" name="radio-1" id="radio-1" >
                            <label for="radio-1">Yes</label>
                        </div>
                        <div class="radiogroup__item">
                            <input class="radio input--edit" type="radio" value="0" name="radio-1" id="radio-2" >
                            <label for="radio-2">No</label>
                        </div>
                    </div>
                </div>
                <div class="popup__form__row">
                    <div class="label">Properties</div>
                    <div class="radiogroup radiogroup">
                        <div class="radiogroup__item">
                            <input class="checkbox put-value" data-column="ph" type="checkbox" name="checkbox-1" id="checkbox-1">
                            <label for="checkbox-1">is PH needed?</label>
                        </div>
                        <div class="radiogroup__item">
                            <input class="checkbox  put-value" data-column="pool" type="checkbox" name="checkbox-2" id="checkbox-2">
                            <label for="checkbox-2">for Pools</label>
                        </div>
                        <div class="radiogroup__item">
                            <input class="checkbox  put-value" data-column="whirlpool" type="checkbox" name="checkbox-3" id="checkbox-3">
                            <label for="checkbox-3">for Whirlpools</label>
                        </div>
                    </div>
                </div>';
        break;
}

echo json_encode($return);


