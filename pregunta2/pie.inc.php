<!-- AUDIENIES-->
</div>
</div>
</div>
</div>
</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">BETA <a
        href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash.</span>
    <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Copyright © 2024</span>
  </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->

<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="assets/vendors/chart.js/chart.umd.js"></script>
<script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/template.js"></script>
<script src="assets/js/settings.js"></script>
<script src="assets/js/hoverable-collapse.js"></script>
<script src="assets/js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="assets/js/dashboard.js"></script>
<!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
<!-- End custom js for this page-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function buscarPersona() {
    const query = $('input[name="ci"]').val(); // Aseguramos que el nombre coincide con el campo

    // Realizar la petición AJAX para buscar personas por CI
    $.ajax({
      url: '', // Aquí se está usando el mismo archivo
      method: 'GET',
      data: { ci: query }, // Aquí también usamos 'ci'
      success: function (data) {
        // Actualizar el cuerpo del modal con los datos devueltos
        $('#modalBody').html($(data).find('#modalBody').html());
        $('#resultadoModal').modal('show'); // Mostrar el modal
      },
      error: function () {
        alert('Error al buscar. Intente nuevamente.');
      }
    });
  }
  function buscarCatastro() {
    const query = $('input[name="ci"]').val(); // Asegúrate de que el nombre coincide con el campo

    // Realizar la petición AJAX para buscar catastro por id
    $.ajax({
      url: '', // Aquí se está usando el mismo archivo
      method: 'GET',
      data: { ci: query }, // Cambié 'zona' por 'id' para que sea consistente
      success: function (data) {
        // Actualizar el cuerpo del modal con los datos devueltos
        $('#modalBody1').html($(data).find('#modalBody1').html());
        $('#resultadoModal1').modal('show'); // Mostrar el modal
      },
      error: function () {
        alert('Error al buscar. Intente nuevamente.');
      }
    });
}

</script>
</body>

</html>