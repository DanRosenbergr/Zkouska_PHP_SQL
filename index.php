<?php
require_once('dblogin.php');

try {
    $con = mysqli_connect($host, $user, $pass, $dbname);
    if (!$con) {
        die("Chyba připojení: " . mysqli_connect_error());
    }

    // Dotaz pro vypis do tabulky
    $query = "SELECT productId, isbn, krestni, prijmeni, nazev, popis, obrazek FROM product";
    
    $stmt = mysqli_prepare($con, $query);
       
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);


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
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Knihy</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" href="index.php">Výpis knih</a>
        <a class="nav-link" href="formAdd.php">Vlož knihu</a>
        <a class="nav-link" href="formSearch.php">Vyhledej knihu</a>
      </div>
    </div>
  </div>
</nav>

<div class="container">
    <h3 class="text-center my-4">Výpis knih</h3>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped table-light">
                <thead>
                    <tr>
                        <th class="col-1 text-center">ISBN</th>
                        <th class="col-1 text-center">Jméno autora</th>
                        <th class="col-1 text-center">Příjmení autora</th>
                        <th class="col-2 text-center">Název knihy</th>
                        <th class="col-4 text-center">Popis</th>
                        <th class="col-3 text-center">Obálka</th> <!-- Nový sloupec pro obrázek -->
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php while ($radek = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($radek['isbn']); ?></td>
                            <td><?php echo htmlspecialchars($radek['krestni']); ?></td>
                            <td><?php echo htmlspecialchars($radek['prijmeni']); ?></td>
                            <td><?php echo htmlspecialchars($radek['nazev']); ?></td>
                            <td><?php echo htmlspecialchars($radek['popis']); ?></td>
                            <td>
                                <?php if (!empty($radek['obrazek'])): ?>
                                    <div class="d-flex justify-content-center">
                                        <img src="<?php echo htmlspecialchars($radek['obrazek']); ?>"
                                             class="img-fluid" style="max-height: 250px;"
                                             alt="Obálka knihy">
                                    </div>
                                <?php else: ?>
                                    <p>Obrázek není dostupný</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>   
    </div>  
</div>



    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
</body>
</html>