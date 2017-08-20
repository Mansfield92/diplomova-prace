<?php
header('Content-Type: application/json');

$responses = array(
    'POST' => array(
        'success' => 'All category changes has been successful',
        'fail' => 'Changes in category failed with these errors: '
    ),
    'PUT' => array(
        'success' => 'New category has been created',
        'fail' => 'Creating new category failed with these errors: '
    ),
    'DELETE' => array(
        'success' => 'Category has been deleted',
        'fail' => 'Category deletion failed with these errors: '
    )
);

$table = 'category';
$data = (string)file_get_contents('php://input');
$data = json_decode($data, true);

switch ($method) {
    case 'GET':
        break;

    case 'POST':

        $update = genericUpdate($table, $data);
        $update = $con->query($update);
        $update = $con->error;

        $delete = $con->query("DELETE FROM category_product where id_category = $data[id]");
        $values = '';

        $products = $data['values']['category_product'];
        if(count($products) > 0){
            for($i = 0; $i < count($products); $i++){
                $values .= "(NULL, $data[id], $products[$i]),";
            }

            $values = rtrim($values, ',');
            $insert = $con->query("INSERT INTO category_product (id_connection, id_category, id_product) VALUES $values");
            $insert = $con->error;
        }else{
            $insert = false;
        }

        if($update || $insert){
            $response = array(
                'message' => ($responses[$method]['fail'].($update ? '</br>'.$update : '').($insert ? '</br>'.$insert : '')),
                'status' => 'fail','header' => 'Error');
        }else{
            $response = array(
                'message' => ($responses[$method]['success']),
                'status' => 'success', 'header' => 'Success');
        }

        echo json_encode($response);

        break;

    case 'PUT':
        echo json_encode(genericInsert($table, $data, $con, $responses[$method]));
        break;

    case 'DELETE':
        echo json_encode(genericDelete($table, $data, $con, $responses[$method]));
        break;
}
