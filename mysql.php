<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <form method="post">
   <p>urun ID<input type="text" name="id"> </p>
    <p>urun adı<input type="text" name="adi"></p>
    <p>Fiyat<input type="text" name="fiyat"></p>
    <p>stok<input type="text" name="stok"></p>
    <input type="submit" value="ekle" name="ekle">
    <input type="submit" value="sil" name="sil">
    <input type="submit" value="listele" name="listele">
    <input type="submit" value="güncelle" name="güncelle">
    </>


    <?php
    $baglan=new mysqli("localhost","root","","market");
    if(!$baglan->connect_error){
        echo "baglantı başarılı";
    }
    else{
        echo "hata";
    }

    if(isset($_POST['ekle'])){
        $ad=$_POST['adi'];
        $fiyat=$_POST['fiyat'];
        $stok=$_POST['stok'];
        $sql=$baglan->prepare("insert into urunler(urunAdı,fiyat,stok)values(?,?,?)");
        $sql->bind_param("sii",$ad,$fiyat,$stok);
        if($sql->execute()){
            echo "kayit eklendi";
        }
    }



    if(isset($_POST['listele'])){
    $sql="select * from urunler order by urunID";
    $sonuc=$baglan->query($sql);
    if($sonuc->num_rows>0){
        echo "<table order=1> <tr><th>ID</th><th>urunAdı</th><th>fiyat</th><th>stok</th></tr>";
        while($satir=$sonuc->fetch_assoc()){
            echo "<tr><td>".$satir["urunID"]."</td><td>".$satir["urunAdı"]."</td><td>".$satir["fiyat"]."</td><td>".$satir["stok"]."</td></tr>";
        }
        echo "</table>";
    }
    else{
        echo "kayit bulunamadi";
        
    }
    }




        if(isset($_POST['sil'])){
            $id=$_POST['id'];
            if($id==""){
                echo"geçerli veri giriniz";
            }
            $sql=$baglan->prepare("delete from urunler where urunID=?");
            $sql->bind_param("i",$id);
            if($sql->execute()){
                echo "kayit silindi";
            }
            
        }    
 


        if(isset($_POST['güncelle'])){
            $id=$_POST['id'];
            $ad=$_POST['adi'];
            $fiyat=$_POST['fiyat']; 
            $stok=$_POST['stok']; 
            if($id==""){
                echo "geçerli veri giriniz";
            }
            else{
                $sql=$baglan->prepare("update urunler set urunAdı=?,fiyat=?,stok=? where urunID=?");
                $sql->bind_param("siii",$ad,$fiyat,$stok,$id);
                if($sql->execute()){
                    echo "güncelleme başarılı";
                }
            }
        }
    
    ?>

</body>
</html>