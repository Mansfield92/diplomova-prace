<?php
header('Content-Type: application/json');

$responses = array(
    'POST' => array(
        'success' => 'Changes has been saved successfully',
        'fail' => 'Changes failed with these errors: '
    ),
    'PUT' => array(
        'success' => 'New users has been created, please wait for your Administrator to confirm registration.',
        'fail' => 'New user failed to be created. Please try to use different nickname.'
    ),
    'DELETE' => array(
//        'success' => 'Nová kategorie byla vytvořena',
        'fail' => 'Uživatele se nepodařilo smazat'
    )
);

$table = 'users';
$data = (string)file_get_contents('php://input');
$data = json_decode($data, true);

switch ($method) {
    case 'POST':

        if(isset($data['values']['password'])){
            $data['values']['password'] = md5($data['values']['password']);
        }

        $update = genericUpdate($table, $data);
        $update = $con->query($update);
        $update = $con->error;

        if($update){
            $response = array(
                'message' => ($responses[$method]['fail'].($update ? '</br>'.$update : '').($insert ? '</br>'.$insert : '')),
                'status' => 'fail','header' => 'Error');
        }
        else{
            $response = array(
                'message' => ($responses[$method]['success']),
                'status' => 'success', 'header' => 'Success');
        }

        echo json_encode($response);

        break;
    case 'PUT':
        $data['values']['password'] = md5($data['values']['password']);
        $result = genericInsert($table, $data, $con, $responses[$method]);

        if($result['status'] == 'fail'){
            $result['message'] = $responses[$method]['fail'];
        }

        echo json_encode($result);
        break;
    case 'DELETE':
        echo json_encode(genericDelete($table, $data, $con, $responses[$method]));
        break;
}
