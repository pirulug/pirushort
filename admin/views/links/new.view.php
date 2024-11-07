<?php require BASE_DIR . "/admin/views/partials/top.partial.php"; ?>
<?php require BASE_DIR . "/admin/views/partials/navbar.partial.php"; ?>

<div class="card">
  <div class="card-body">

    <form action="" method="post">
      <div class="mb-3">
        <label class="form-label" for="">Titulo</label>
        <input type="text" class="form-control" name="title" placeholder="Un titulo" require>
      </div>
      <div class="mb-3">
        <label class="form-label" for="">Link</label>
        <input type="url" class="form-control" name="link" placeholder="http://google.com" require>
      </div>
      <button class="btn btn-primary" type="submit">Guardar</button>
    </form>

  </div>
</div>

<?php require BASE_DIR . "/admin/views/partials/footer.partial.php"; ?>
<?php require BASE_DIR . "/admin/views/partials/bottom.partial.php"; ?>