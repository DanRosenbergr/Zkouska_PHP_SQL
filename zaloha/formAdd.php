
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add form</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
  </head>
  <body>
    
    <h3 class="text-center">Zadejte parametry produktu</h3>
    <div class="container">
      <form action="add.php" method="POST">
        <div class="my-2">
          <label class="form-label" for="name">Nazev produktu</label>
          <input
            class="form-control"
            type="text"
            name="nazev"
            id="name"
            placeholder="zadejte nazev"
            required
          />
        </div>
        <div class="my-2">
          <label class="form-label" for="cena">Cena:</label>
          <input
            class="form-control"
            type="number"
            name="cena"
            placeholder="zadejte cenu"
            id="price"
            required
          />
        </div>
        <div class="my-2">
          <label class="form-label" for="popis">Popis produktu</label>
          <textarea
            class="form-control"
            type="text"
            name="popis"
            id="popis"
            cols="50"
            rows="5"
            placeholder="zadejte popis"
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
