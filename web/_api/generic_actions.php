<?php

function genericUpdate( $table, $data){
    $id = $data['postID'];
    $columns = $data['columns'];
    $values = $data['values'];

    $query = "UPDATE `$table` SET ";
    for($i = 0; $i < count($columns); $i++){
        $column = $columns[$i];
        if(strpos($column, '-') !== false){
            $column = substr($column, 0, strpos($column, '-'));
        }

        $query.=" `$column` = '".$values[$columns[$i]]."',";
    }
    $query = rtrim($query, ",");
    $query .= " WHERE $id";

    return $query;
}


function genericInsert( $table, $data, $con, $responses){
    $columns = $data['columns'];
    $values = $data['values'];

    $insertColumms = '(';
    $insertValues = ' VALUES (';

    $query = "INSERT INTO `$table` ";
    for($i = 0; $i < count($columns); $i++){
        $column = $columns[$i];
        if(strpos($column, '-') !== false){
            $column = substr($column, 0, strpos($column, '-'));
        }

        $insertColumms .= "`$column`,";
        $insertValues .= ($values[$columns[$i]] == 'NULL' ? "NULL, " : "'".$values[$columns[$i]]."',");
    }

    $insertColumms = rtrim($insertColumms, ",");
    $insertColumms .= ')';
    $insertValues = rtrim($insertValues, ",");
    $insertValues .= ')';

    $insert = $query.$insertColumms.$insertValues;
    $insert = $con->query($insert);
    $insert = $con->error;

    if($insert){
        $response = array(
            'message' => ($responses['fail'].($insert ? '</br>'.$insert : '')),
            'status' => 'fail','header' => 'Error');
    }else{
        $response = array(
            'message' => ($responses['success']),
            'status' => 'success','header' => 'Success','id' => $con->insert_id);
    }

    return $response;

}


function genericDelete($table, $data, $con, $responses){
    $delete = "DELETE from $table WHERE $data[id]";
    $delete = $con->query($delete);
    $delete = $con->error;

    if($delete){
        $response = array(
            'message' => ($responses['fail'].($delete ? '</br>'.$delete : '')),
            'status' => 'fail','header' => 'Error');
    }else{
        $response = array(
            'status' => 'success');
    }

    return $response;
}
