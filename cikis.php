<?php 
    require_once 'baglan.php';

    $logekle = $db->prepare("INSERT INTO loglar SET
        uyeid=:u,
        ip=:i,
        tarih=:t,
        aciklama=:a
    ");

    $logekle->execute([
        ':u' => $_SESSION['id'],
        ':i' => IP(),
        ':t' => date('Y-m-d H:i:s'),
        ':a' => "Sistemden çıkış yaptı"
    ]);


    session_destroy();
    header('Location:index.php');
?>