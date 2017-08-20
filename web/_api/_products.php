<?php

header('Content-Type: application/json');

$responses = array(
    'POST' => array(
        'success' => 'Changes has been saved successfully',
        'fail' => 'Changes failed with these errors: '
    ),
    'DELETE' => array(
        'success' => 'Product has been deleted',
        'fail' => 'Product failed to be deleted with this error: '
    )
);

$table = 'products';
$data = (string)file_get_contents('php://input');
$data = json_decode($data, true);

switch ($method) {

    case 'GET':
        break;

    case 'POST':
        $update = genericUpdate($table, $data);
        $update = $con->query($update);
        $update = $con->error;

        if($update){
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


    case 'DELETE':
        echo json_encode(genericDelete($table, $data, $con, $responses[$method]));
        break;
}
