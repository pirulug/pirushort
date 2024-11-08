<?php require BASE_DIR . "/admin/views/partials/top.partial.php"; ?>
<?php require BASE_DIR . "/admin/views/partials/navbar.partial.php"; ?>

<div class="card">
  <div class="card-body">
    <form method="GET" action="">
      <div class="input-group mb-3">
        <input class="form-control" type="search" name="search" value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary" type="submit">Buscar</button>
      </div>
    </form>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead>
          <tr>
            <th>Titulo</th>
            <th>Link</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($links as $link): ?>
            <tr>
              <td><?= $link->title ?></td>
              <td><?= $link->link ?></td>
              <td>
                <a href="<?= SITE_URL . "/" . $link->short ?>" class="btn btn-sm btn-info" target="_blank"
                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Link">
                  <i class="fa fa-link"></i>
                </a>
                <a href="view.php?shot=<?= $link->short ?>" class="btn btn-sm btn-blue" data-bs-toggle="tooltip"
                  data-bs-placement="top" data-bs-title="Estadística">
                  <i class="fa fa-eye"></i>
                </a>
                <a href="edit.php?id=<?= $encryption->encrypt($link->id) ?>" class="btn btn-sm btn-success"
                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                  <i class="fa fa-pen"></i>
                </a>
                <a href="delete.php?id=<?= $encryption->encrypt($link->id) ?>" class="btn btn-sm btn-danger"
                  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Eliminar"
                  onClick="return confirm('¿Quieres eliminar?')">
                  <i class="fa fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php renderPagination($offset, $limit, $total_results, $page, $search, $total_pages) ?>
  </div>
</div>

<?php require BASE_DIR . "/admin/views/partials/footer.partial.php"; ?>
<?php require BASE_DIR . "/admin/views/partials/bottom.partial.php"; ?>