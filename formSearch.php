<?php
require_once('dblogin.php');

try {
    $con = mysqli_connect($host, $user, $pass, $dbname);
    if (!$con) {
        die("Chyba připojení: " . mysqli_connect_error());
    }

    $query = "SELECT productId, isbn, krestni, prijmeni, nazev, popis, obrazek FROM product";
    $params = [];
    $types = "";

    $hasFilter = !empty($_GET['searchisbn']) || !empty($_GET['searchkrestni']) || !empty($_GET['searchprijmeni']) || !empty($_GET['searchnazev']);

    if ($hasFilter) {
        $query .= " WHERE 1=1";

        if (!empty($_GET['searchisbn'])) {
            $query .= " AND isbn LIKE ?";
            $params[] = "%" . trim($_GET['searchisbn']) . "%";
            $types .= "s";
        }
        if (!empty($_GET['searchkrestni'])) {
            $query .= " AND krestni LIKE ?";
            $params[] = "%" . trim($_GET['searchkrestni']) . "%";
            $types .= "s";
        }
        if (!empty($_GET['searchprijmeni'])) {
            $query .= " AND prijmeni LIKE ?";
            $params[] = "%" . trim($_GET['searchprijmeni']) . "%";
            $types .= "s";
        }
        if (!empty($_GET['searchnazev'])) {
            $query .= " AND nazev LIKE ?";
            $params[] = "%" . trim($_GET['searchnazev']) . "%";
            $types .= "s";
        }
    }

    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        die("Chyba při přípravě dotazu.");
    }
} catch (Exception $e) {
    die("Došlo k chybě při komunikaci. Chyba: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vyhledávání knih</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <a class="nav-link" href="index.php">Výpis knih</a>
        <a class="nav-link" href="formAdd.php">Vlož knihu</a>
        <a class="nav-link active" href="formSearch.php">Vyhledej knihu</a>
      </div>
    </div>
  </div>
</nav>

<!-- Vyhledávací formulář -->
<div class="container">
    <h3 class="text-center my-4">Vyhledej knihu</h3>
    <form method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-3">
                <input type="text" name="searchisbn" class="form-control" placeholder="podle ISBN?.." 
                    value="<?php echo isset($_GET['searchisbn']) ? htmlspecialchars($_GET['searchisbn']) : ''; ?>">
            </div>
            <div class="col-3">
                <input type="text" name="searchkrestni" class="form-control" placeholder="jméno?.." 
                    value="<?php echo isset($_GET['searchkrestni']) ? htmlspecialchars($_GET['searchkrestni']) : ''; ?>">
            </div>
            <div class="col-3">
                <input type="text" name="searchprijmeni" class="form-control" placeholder="příjmení?.." 
                    value="<?php echo isset($_GET['searchprijmeni']) ? htmlspecialchars($_GET['searchprijmeni']) : ''; ?>">
            </div>
            <div class="col-3">
                <input type="text" name="searchnazev" class="form-control" placeholder="název?.." 
                    value="<?php echo isset($_GET['searchnazev']) ? htmlspecialchars($_GET['searchnazev']) : ''; ?>">
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-lg mt-2">Hledej</button>
        </div>
    </form>
</div>

<!-- Výpis knih pouze pokud je vyhledávání aktivní -->
<?php if ($hasFilter): ?>
    <div class="container">
        <h3 class="text-center my-4">Výpis knih</h3>
        <div class="row">
            <div class="col-12">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <table class="table table-striped table-light">
                        <thead>
                            <tr>
                                <th class="col-1 text-center">ISBN</th>
                                <th class="col-1 text-center">Jméno autora</th>
                                <th class="col-1 text-center">Příjmení autora</th>
                                <th class="col-2 text-center">Název knihy</th>
                                <th class="col-4 text-center">Popis</th>
                                <th class="col-3 text-center">Obálka</th>
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
                <?php else: ?>
                    <p class="text-center">Žádné knihy neodpovídají vyhledávání.</p>
                <?php endif; ?>
            </div>   
        </div>  
    </div>
<?php endif; ?>

</body>
</html>
