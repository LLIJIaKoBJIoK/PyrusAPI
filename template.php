<html lang="en">
  <head>
    <title>Test Pyrus API</title>
    <meta charset="x-UTF-16LE-BOM">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>

  <body>
  <div class="container text-center">
    <div class="row">
      <div class="col-3">
        <form action="index.php" method="post">
          <div class="mb-3 ">
            <label for="taskId" class="form-label">Task ID</label>
            <input type="text" name="taskId" class="form-control" id="taskId">
          </div>
            <button type="submit" name="getTasks" class="btn btn-primary">Get Tasks</button>
            <button type="submit" name="getTask" class="btn btn-secondary">Get Task</button>
        </form>
      </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
