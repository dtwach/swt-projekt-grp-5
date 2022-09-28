<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_POST['register_submit'])) {
    require 'dbcon.inc.php';
    $name = htmlspecialchars($_POST['name']);
    $password = htmlspecialchars($_POST['password']);
    $password_again = htmlspecialchars($_POST['password_again']);
    if (empty($name) || empty($password) || empty($password_again)) {
        if (empty($name)) {
            header('Location: ../register.php?ms=empty');
            exit();
        }
        header('Location: ../register.php?ms=empty&name=' . $name);
        exit();
    } else if ($password !== $password_again) {
        header('Location: ../register.php?ms=even&name=' . $name);
        exit();
    } else {
        $stmt = $con->prepare("SELECT * FROM user WHERE Username=?;");
        if (!$stmt) {
            header('Location: ../register.php?ms=db&name=' . $name);
            exit();
        }
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->store_result();
        $result = $stmt->num_rows();
        if ($result > 0) {
            header('Location: ../register.php?ms=taken&name=' . $name);
            exit();
        } else {
            $stmt->close();
            $stmt = $con->prepare("INSERT INTO user (Username, PassHash, Rolle) VALUES (?, ?, ?);");
            if (!$stmt) {
                header('Location: ../register.php?ms=db&name=' . $name);
                exit();
            }
            $rolle = 1;
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('ssi', $name, $passwordhash, $rolle);
            $stmt->execute();
            if (!$stmt) {
                header('Location: ../register.php?ms=fail&name=' . $name);
                exit();
            }
            $stmt->close();
            $stmt = $con->prepare("SELECT * FROM user WHERE Username=?;");
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $_SESSION['user'] = $name;
            $_SESSION['id'] = $result['ID'];
            header('Location: ../index.php');
            exit();
        }
    }
    $stmt->close();
    $con->close();
    exit();
}
