<?php
    session_start();
    include '../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:../index.php');
}

    $output = [];
    $password = post('passwordUpdate');

    $input = [];
    $input['usernameUpdate']    = post('usernameUpdate');
    $input['firstnameUpdate']   = post('firstnameUpdate');
    $input['lastnameUpdate']    = post('lastnameUpdate');
    $input['emailUpdate']       = post('emailUpdate');
    $input['phonenumberUpdate'] = post('phonenumberUpdate');
    $input['pinUpdate']         = post('pinUpdate');
    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}
else if (!filter_var($input['emailUpdate'], FILTER_VALIDATE_EMAIL)) {

    $output['errors']['emailUpdate'] = 'Enter correct Email ID';
    $output['status'] = 'fail';
    echo json_encode($output);
    die;
}

    $userId = post('id');

$parameters = '';
if ($_POST) {

    // SELECT MATCH FROM THE DATABASE
    $query     = 'SELECT * FROM `users` where username=? and id !='.$userId;
    $statement = $db->prepare($query);
    $statement->execute(array(post('usernameUpdate')));

    $userData = $db->prepare('SELECT * FROM users WHERE id=?');
    $userData->execute(array($userId));
    $rowUser = $userData->fetch(PDO::FETCH_ASSOC);

    if ($statement->rowCount() > 0) {

        // $output['status'] = 'fail';
        $output['errors']['usernameUpdate'] = array('User with this username already exists.Try different username');
        echo json_encode($output);
        die;
        
    } else {

        // Encrypt password according to encryption type defined in config.php
        if($encryptionType == 'sha1') {
            $password = sha1(post('passwordUpdate'));

        } elseif ($encryptionType == 'md5') {
            $password = md5(post('passwordUpdate'));
        }



        // When no image is selected

            $query      = 'UPDATE  `users` SET username = ?, password=?, email=?, firstname = ?, lastname = ?, phonenumber = ?, pin = ? where id=?';
            $parameters = array(post('usernameUpdate'), post('passwordUpdate') != null ? $password : $rowUser['password'], post('emailUpdate'), post('firstnameUpdate'), post('lastnameUpdate'), post('phonenumberUpdate'), post('pinUpdate'), $userId);

        

        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('User updated successfully');

    }

}
echo json_encode($output);
?>