
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