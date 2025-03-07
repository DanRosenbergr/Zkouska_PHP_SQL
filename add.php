<?php 
 require_once ('dblogin.php');

 try {
    $con = mysqli_connect($host, $user, $pass, $dbname);

    if (!$con) {
        die("Chyba připojení: " . mysqli_connect_error());
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $isbn = trim($_POST['isbn']);
        $krestni = trim($_POST['krestni']);
        $prijmeni = trim($_POST['prijmeni']);
        $nazev = trim($_POST['nazev']);
        $popis = trim($_POST['popis']);
        $obrazek = trim($_POST['obrazek']);

        if ($isbn != "" && $krestni != "" && $prijmeni != "" && $nazev != "" && $popis != "" && $obrazek != ""){

          $query = "INSERT INTO product (isbn, krestni, prijmeni, nazev, popis, obrazek) VALUES (?,?,?,?,?,?)";
          $stmt =mysqli_prepare($con, $query);
          
          if($stmt){
              mysqli_stmt_bind_param($stmt, "ssssss", $isbn, $krestni, $prijmeni, $nazev, $popis, $obrazek);
              $execute = mysqli_stmt_execute($stmt);
              if($execute){
                  echo "Vlozeno";
              }else{
                  echo "Chyba pri vkladani" . mysqli_error($con);
              }
              mysqli_stmt_close($stmt);
          }else {
            echo "Chyba pri priprave dotazu.";
        }
      } else{
        echo "Vyplnte spravne udaje";
    }
    header("location: index.php");
    exit();
    }

} catch (Exception $e) {
        echo "Došlo k chybě při komunikaci. chyba" . $e->getMessage();
}
?>
