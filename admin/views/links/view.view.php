<?php blockStart("style"); ?>

<?php blockEnd("style"); ?>

<?php blockStart("script"); // Block ?>
<script src="<?= SITE_URL ?>/admin/assets/js/chartjs.js"></script>
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

<?php require BASE_DIR . "/admin/views/partials/top.partial.php"; ?>
<?php require BASE_DIR . "/admin/views/partials/navbar.partial.php"; ?>

<div class="row">
  <div class="col-4">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title h5">Gráfica por Día</h2>
      </div>
      <div class="card-body">
        <canvas id="chartDay" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
  <div class="col-4">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title h5">Gráfica por Mes</h2>
      </div>
      <div class="card-body">
        <canvas id="chartMonth" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
  <div class="col-4">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title h5">Gráfica por Año</h2>
      </div>
      <div class="card-body">
        <canvas id="chartYear" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
</div>

<?php require BASE_DIR . "/admin/views/partials/footer.partial.php"; ?>
<?php require BASE_DIR . "/admin/views/partials/bottom.partial.php"; ?>