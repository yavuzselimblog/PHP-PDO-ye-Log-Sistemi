<?php require 'baglan.php';

if($_POST){

    $kadi  = $_POST['kadi'];
    $sifre = $_POST['sifre'];

    $girisyap = $db->prepare("SELECT * FROM uyeler WHERE kadi=:k AND sifre=:s");
    $girisyap->execute([':k'=>$kadi,':s'=>sha1(md5($sifre))]);
    if($girisyap->rowCount()){

        $row = $girisyap->fetch(PDO::FETCH_OBJ);
        $_SESSION['oturum'] = true;
        $_SESSION['kadi']   = $row->kadi;
        $_SESSION['id']     = $row->id;

     

        $logekle = $db->prepare("INSERT INTO loglar SET
            uyeid=:u,
            ip=:i,
            tarih=:t,
            aciklama=:a
        ");

        $logekle->execute([
            ':u' => $row->id,
            ':i' => IP(),
            ':t' => date('Y-m-d H:i:s'),
            ':a' => "Sisteme giriş yaptı"
        ]);

        $metin = $row->id." - ".IP()." - ".date('Y-m-d H:i:s');
        $fp = fopen('loglar.txt', 'a');
        fwrite($fp, $metin);
        fclose($fp);

        echo 'Başarıyla giriş yaptınız bekleyiniz...';
        header('refresh:2;url=profil.php');

    }else{
        echo "kullanıcı adı veya şifre yanlış";
    }

}


?>

<form action="" method="POST">
<input type="text" name="kadi" placeholder="Kullanıcı adı" /><br>
<input type="password" name="sifre" placeholder="Şifre" /><br>
<button type="submit">Giriş yap</button>
</form>