<?php
require_once('dblogin.php');

try {
    $con = mysqli_connect($host, $user, $pass, $dbname);
    if (!$con) {
        die("Chyba připojení: " . mysqli_connect_error());
    }

    // Výchozí dotaz
    $query = "SELECT productId, nazev, cena, popis FROM product";
    
    // Pokud je zadaný filtr
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = trim($_GET['search']);
        $query = " WHERE nazev LIKE ?";
    }

    $stmt = mysqli_prepare($con, $query);
    
    if (isset($search)) {
        $search = "%" . $search . "%";
        mysqli_stmt_bind_param($stmt, "s", $search);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Výpočet celkového součtu cen všech produktů
    $totalQuery = "SELECT SUM(cena) AS total FROM product";
    $totalResult = mysqli_query($con, $totalQuery);
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalPrice = $totalRow['total'];

    // Vložení celkové ceny do tabulky jako nový záznam
    // $insertQuery = "INSERT INTO product (nazev, cena, popis) VALUES ('Celková cena', ?, 'Součet všech produktů')";
    // $insertStmt = mysqli_prepare($con, $insertQuery);
    // mysqli_stmt_bind_param($insertStmt, "d", $totalPrice);
    // mysqli_stmt_execute($insertStmt);
    // mysqli_stmt_close($insertStmt);


} catch (Exception $e) {
    echo "Došlo k chybě při komunikaci. Chyba: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vypis</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
</head>
<body>

<div class="container my-2">
    <h3 class="text-center mb-4">Vypis produktu</h3>

    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Hledat podle názvu..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-primary mt-2">Hledat</button>
    </form>

    <table class="table table-striped">
        <tr>
        <th>Nazev</th>
        <th>Cena(kc)</th>
        <th>Popis</th>
        <th>Upravy</th>
        </tr>
    <?php 
     while($radek = mysqli_fetch_array($result)){

        // Formátování cisla(ceny)parametr1: promenna, parametr2: pocet deset.mist,parametr3: jaky oddelovac nuly, parametr4: oddelovac 1000
        $formattedPrice = number_format($radek['cena'], 2, ',', ' '); 
        ?>
        <tr>
            <td><?php echo htmlspecialchars($radek['nazev']) ?></td>
            <td><?php echo $formattedPrice ?></td>
            <td><?php echo htmlspecialchars($radek['popis']) ?></td>
            <td>
                <a class="btn btn-warning" href="formEdit.php?productId=<?php echo $radek['productId']?>">Upravit</a>
                <a class="btn btn-danger" href="delete.php?productId=<?php echo htmlspecialchars($radek['productId']); ?>" 
                    onclick="return confirm('Opravdu chceš smazat záznam?')">Smazat</a>
            </td>
        </tr>                 
        <?php
     }
    ?>
    <tr>
        <td><strong>Celkova cena</strong></td>
        <td><?php echo htmlspecialchars(number_format($totalPrice,2,',',' '))?> kc</td>
        <td></td>
        <td></td>
    </tr>
     </table>
     <form method="POST" action="formAdd.php">
        <input type="submit" class="btn btn-success" value="Pridej zaznam">
     </form>
 </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
</body>
</html>