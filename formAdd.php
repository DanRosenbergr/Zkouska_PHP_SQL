
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vloz knihu</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
  </head>
  <body class="bg-light">
    
  <nav class="navbar navbar-expand-lg bg-body-tertiary ">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Knihy</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="index.php">Výpis knih</a>
        <a class="nav-link active" href="formAdd.php">Vlož knihu</a>
        <a class="nav-link" href="search.php">Vyhledej knihu</a>
      </div>
    </div>
  </div>
</nav>


    <h3 class="text-center my-4">Zadejte parametry knihy</h3>
    <div class="container col-6">
      <form action="add.php" method="POST">
        <div class="my-2">
          <label class="form-label" for="isbn">ISBN</label>
          <input
            class="form-control"
            type="text"
            name="isbn"
            id="isbn"
            placeholder="zadejte ISBN"
            required
          />
        </div>
        <div class="my-2">
          <label class="form-label" for="krestni">Jméno autora</label>
          <input
            class="form-control"
            type="text"
            name="krestni"
            placeholder="zadejte jemno autora"
            
            required
          />
        </div>
        <div class="my-2">
          <label class="form-label" for="prijmeni">Příjemní autora</label>
          <input
            class="form-control"
            type="text"
            name="prijmeni"
            placeholder="zadejte příjmení autora"          
            required
          />
        </div>
        <div class="my-2">
          <label class="form-label" for="nazev">Název knihy</label>
          <input
            class="form-control"
            type="text"
            name="nazev"
            placeholder="zadejte název knihy"
            required
          />
        </div>
        <div class="my-2">
          <label class="form-label" for="obrazek">Fotka knihy</label>
          <input
            class="form-control"
            type="text"
            name="obrazek"
            placeholder="zadejte link na zdrojový obrázek"
            required
          />
        </div>

        <div class="my-2">
          <label class="form-label" for="popis">Popis knihy</label>
          <textarea
            class="form-control"
            type="text"
            name="popis"
            id="popis"
            cols="50"
            rows="5"
            placeholder="zadejte popis knihy"
            required
          ></textarea>
        </div>
        <input class="btn btn-warning" type="submit" value="Ulozit zaznam" />
      </form>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
