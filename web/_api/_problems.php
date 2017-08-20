<?php
header('Content-Type: application/json');

$responses = array(
    'POST' => array(
        'success' => 'Changes has been saved successfully',
        'fail' => 'Changes failed with these errors: '
    ),
    'PUT' => array(
        'success' => 'New issue has been created',
        'fail' => 'New issue failed to be created'
    ),
    'DELETE' => array(
        'success' => 'Issue has been deleted',
        'fail' => 'Issue failed to be deleted'
    )
);

$table = 'problem';
$data = (string)file_get_contents('php://input');
$data = json_decode($data, true);

switch ($method) {

    case 'POST':

        $update = genericUpdate($table, $data);
        $update = $con->query($update);
        $update = $con->error;

        $delete = $con->query("DELETE FROM problem_category where id_problem = $data[id]");
        $delete = $con->query("DELETE FROM translations where id_problem = $data[id]");
        $values = '';
//
        $products = $data['values']['problem_category'];
        if(count($products) > 0){
            for($i = 0; $i < count($products); $i++){
                $values .= "($products[$i],$data[id]),";
            }

            $values = rtrim($values, ',');
            $insert = $con->query("INSERT INTO problem_category (id_category, id_problem) VALUES $values");
            $insert = $con->error;
        }else{
            $insert = false;
        }

        $values = '';
        $translations = $data['values']['translations'];

        if(count($translations) > 0){
            foreach ($translations as $key => $value){
                $values .= "(NULL, '$key', $data[id], '$value[name]', '$value[description]'),";
            }
//            echo $values;
            $values = rtrim($values, ',');

            $insert = $con->query("INSERT INTO translations (id_translation, lang, id_problem, header, content) VALUES $values");
            $insert = $con->error;
        }else{
            $insert = false;
        }

        if($update || $insert){
            $response = array(
                'message' => ($responses[$method]['fail'].($update ? '</br>'.$update : '').($insert ? '</br>'.$insert : '')),
                'status' => 'fail','header' => 'Chyba');
        }else{
            $response = array(
                'message' => ($responses[$method]['success']),
                'status' => 'success', 'header' => 'Success');
        }

        echo json_encode($response);

        break;
    case 'PUT':

        $insert = genericInsert($table, $data, $con, $responses[$method]);
        $id = $insert['id'];

        $con->query("INSERT INTO `translations` (`id_translation`, `lang`, `id_problem`, `header`, `content`) VALUES (NULL, 'cs', '$id', '', ''), (NULL, 'en', '$id', '', ''), (NULL, 'ru', '$id', '', ''), (NULL, 'de', '$id', '', '')");

        echo json_encode($insert);

        break;
    case 'DELETE':
        echo json_encode(genericDelete($table, $data, $con, $responses[$method]));
        break;
}
