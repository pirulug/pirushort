<?php blockStart("script"); ?>
<script src="<?= APP_URL ?>/admin/assets/js/chartjs.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const dataDay = <?php echo json_encode($data_day); ?>;
    const ctxDay = document.getElementById('chartDay').getContext('2d');
    new Chart(ctxDay, {
      type: 'line',
      data: {
        labels: dataDay.map(d => d.day),
        datasets: [{
          label: 'Registros por Día (Mes Actual)',
          data: dataDay.map(d => d.count),
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1,
          fill: false,
        }]
      },
      options: {
        scales: {
          x: { beginAtZero: true },
          y: { beginAtZero: true }
        }
      }
    });

    // Datos por Mes (solo meses del año actual)
    const dataMonth = <?php echo json_encode($data_month); ?>;
    const ctxMonth = document.getElementById('chartMonth').getContext('2d');
    new Chart(ctxMonth, {
      type: 'bar',
      data: {
        labels: dataMonth.map(d => d.month),
        datasets: [{
          label: 'Registros por Mes (Año Actual)',
          data: dataMonth.map(d => d.count),
          backgroundColor: 'rgba(153, 102, 255, 0.2)',
          borderColor: 'rgba(153, 102, 255, 1)',
          borderWidth: 1,
        }]
      },
      options: {
        scales: {
          x: { beginAtZero: true },
          y: { beginAtZero: true }
        }
      }
    });

    // Datos por Año (últimos 10 años)
    const dataYear = <?php echo json_encode($data_year); ?>;
    const ctxYear = document.getElementById('chartYear').getContext('2d');
    new Chart(ctxYear, {
      type: 'bar',
      data: {
        labels: dataYear.map(d => d.year),
        datasets: [{
          label: 'Registros por Año (Últimos 10 Años)',
          data: dataYear.map(d => d.count),
          backgroundColor: 'rgba(255, 159, 64, 0.2)',
          borderColor: 'rgba(255, 159, 64, 1)',
          borderWidth: 1,
        }]
      },
      options: {
        scales: {
          x: { beginAtZero: true },
          y: { beginAtZero: true }
        }
      }
    });
  });
</script>
<?php blockEnd("script"); ?>

<?php require BASE_DIR_ADMIN . "/views/partials/top.partial.php"; ?>
<?php require BASE_DIR_ADMIN . "/views/partials/navbar.partial.php"; ?>

<?php display_messages(); ?>

<div class="row g-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col mt-0">
            <h5 class="card-title">Visitantes hoy</h5>
          </div>
          <div class="col-auto">
            <div class="stat stat-primary"><i class="align-middle" data-feather="users"></i></div>
          </div>
        </div>
        <h1 class="mt-1 mb-3"><?= $total_visits_today ?></h1>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col mt-0">
            <h5 class="card-title">Visitantes en total</h5>
          </div>
          <div class="col-auto">
            <div class="stat stat-success"><i class="align-middle" data-feather="users"></i></div>
          </div>
        </div>
        <h1 class="mt-1 mb-3"><?= $total_visits_all_time ?></h1>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col mt-0">
            <h5 class="card-title">Enlaces</h5>
          </div>
          <div class="col-auto">
            <div class="stat stat-info"><i class="align-middle" data-feather="link"></i></div>
          </div>
        </div>
        <h1 class="mt-1 mb-3"><?= $total_links ?></h1>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col mt-0">
            <h5 class="card-title">Usuarios</h5>
          </div>
          <div class="col-auto">
            <div class="stat stat-danger"><i class="align-middle" data-feather="users"></i></div>
          </div>
        </div>
        <h1 class="mt-1 mb-3"><?= $total_users ?></h1>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-12 col-md-12 col-xxl-4 d-flex order-3 order-xxl-2">
    <div class="card mb-3 flex-fill w-100">
      <div class="card-header">
        <h5 class="card-title mb-0">Gráfica por Día</h5>
      </div>
      <div class="card-body py-3">
        <canvas id="chartDay" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-12 col-xxl-4 d-flex order-3 order-xxl-2">
    <div class="card mb-3 flex-fill w-100">
      <div class="card-header">
        <h5 class="card-title mb-0">Gráfica por Mes</h5>
      </div>
      <div class="card-body px-4">
        <canvas id="chartMonth" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-12 col-xxl-4 d-flex order-3 order-xxl-2">
    <div class="card mb-3 flex-fill w-100">
      <div class="card-header">
        <h5 class="card-title mb-0">Gráfica por Año</h5>
      </div>
      <div class="card-body px-4">
        <canvas id="chartYear" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
</div>


<div class="card flex-fill overflow-hidden">
  <div class="card-header">
    <h5 class="card-title mb-0">Ultimas visitas</h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle my-0">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>LINK</th>
            <th>Dispositivo</th>
            <th>SO</th>
            <th>Navegador</th>
            <th>IP</th>
            <th>País</th>
            <th>Ciudad</th>
            <th>Referencia</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($visits as $data): ?>
            <tr>
              <td><?= $data->access_time ?></td>
              <td>
                <small><?= APP_URL . "/" . $data->short_link ?></small>
              </td>
              <td><?= $data->device ?></td>
              <td><?= $data->operating_system ?></td>
              <td><?= $data->browser ?></td>
              <td><?= $data->ip_address ?></td>
              <td><?= $data->country ?></td>
              <td><?= $data->city ?></td>
              <td><small><?= $data->referer ?></small></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>



<?php require BASE_DIR_ADMIN . "/views/partials/footer.partial.php"; ?>
<?php require BASE_DIR_ADMIN . "/views/partials/bottom.partial.php"; ?>