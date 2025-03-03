<?php if (isset($_SESSION['mensaje'])): ?>
    <?php 
        $tipo  = $_SESSION['mensaje']['tipo']; 
        $texto = $_SESSION['mensaje']['texto'];

        // Asignar clase de Bootstrap según el tipo
        switch ($tipo) {
            case 'danger':
                $alertClass = 'danger';
                break;
            case 'warning':
                $alertClass = 'warning';
                break;
            case 'salida':
                $alertClass = 'success';
                break;
            case 'entrada':
                $alertClass = 'success';
                break;
            default:
                $alertClass = 'info';
                break;
        }
    ?>

    <!-- Modal -->
    <div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <!-- Encabezado del Modal -->
          <div class="modal-header bg-<?php echo $alertClass; ?> text-white">
            <h5 class="modal-title" id="mensajeModalLabel">Registro de Asistencia</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Cuerpo del Modal -->
          <div class="modal-body">
            <?php if ($tipo === 'entrada'): ?>
              <!-- FASES DEL WIZARD PARA 'ENTRADA' -->

              <!-- Fase 1 -->
              <div id="fase1" class="fase">
                <div class="alert alert-<?php echo $alertClass; ?>">
                  <?php echo htmlspecialchars($texto); ?>
                </div>
                <p class="mb-3">¿Tienes computador?</p>
                <div class="d-grid gap-2">
                  <button class="btn btn-success" id="btnSiComputador">Sí</button>
                  <button class="btn btn-danger" id="btnNoComputador">No</button>
                </div>
              </div>

              <!-- Fase 2 (oculta inicialmente) -->
              <div id="fase2" class="fase d-none mt-3">
                <p class="mb-3">¿El computador es Propio o del SENA?</p>
                <div class="d-grid gap-2">
                  <button class="btn btn-primary" id="btnPropio">Propio</button>
                  <button class="btn btn-info" id="btnSena">SENA</button>
                </div>
              </div>

              <!-- Fase 3: Listado de computadores (oculta inicialmente) -->
              <div id="fase3" class="fase d-none mt-3">
                <p class="mb-3">Selecciona un computador:</p>
                <select id="selectComputadores" class="form-select mb-3"></select>
                <div class="d-grid">
                  <button class="btn btn-success" id="btnConfirmarPC">Confirmar</button>
                </div>
              </div>

            <?php else: ?>
              <!-- MENSAJE SIMPLE PARA SALIDA, WARNING, DANGER, ETC. -->
              <div class="alert alert-<?php echo $alertClass; ?> mb-0" role="alert">
                <?php echo htmlspecialchars($texto); ?>
              </div>
            <?php endif; ?>
          </div>

          <!-- Pie del Modal -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
          let modalEl = document.getElementById('mensajeModal');
          let modal = new bootstrap.Modal(modalEl);
          modal.show();

          let tipoMensaje = "<?php echo $tipo; ?>";  // Evita confusión con "tipoComputador"

          if (tipoMensaje !== "entrada") {
              setTimeout(() => {
                  modal.hide();
              }, 3000);
          }

          if (tipoMensaje === "entrada") {
              const fase1 = document.getElementById("fase1");
              const fase2 = document.getElementById("fase2");
              const fase3 = document.getElementById("fase3");

              document.getElementById("btnSiComputador").addEventListener("click", () => {
                  fase1.classList.add("d-none");
                  fase2.classList.remove("d-none");
              });

              document.getElementById("btnNoComputador").addEventListener("click", () => {
                  modal.hide();
              });

              // Botones para seleccionar tipo de computador
              document.getElementById("btnPropio").addEventListener("click", () => {
                  cargarComputadores("Personal");
              });
              document.getElementById("btnSena").addEventListener("click", () => {
                  cargarComputadores("Sena");
              });

              function cargarComputadores(tipoComputador) {
                  console.log("Tipo de computador enviado:", tipoComputador); // Verifica en consola
                  fase2.classList.add("d-none");
                  fase3.classList.remove("d-none");

                  fetch("obtener_computadores", {
                      method: "POST",
                      headers: { "Content-Type": "application/x-www-form-urlencoded" },
                      body: "tipoComputador=" + encodeURIComponent(tipoComputador) // Cambio de nombre aquí
                  })
                  .then(response => response.json())
                  .then(data => {
                      let select = document.getElementById("selectComputadores");
                      select.innerHTML = "";
                      if (Array.isArray(data) && data.length > 0) {
                          data.forEach(pc => {
                              let option = document.createElement("option");
                              option.value = pc.id;
                              option.textContent = pc.marca + " - " + pc.codigo;
                              select.appendChild(option);
                          });
                      } else {
                          let option = document.createElement("option");
                          option.value = "";
                          option.textContent = "No hay computadores disponibles";
                          select.appendChild(option);
                      }
                  })
                  .catch(error => console.error("Error al cargar computadores:", error));
              }

              document.getElementById("btnConfirmarPC").addEventListener("click", () => {
                  let pcSeleccionado = document.getElementById("selectComputadores").value;
                  if (!pcSeleccionado) {
                      alert("Selecciona un computador válido");
                      return;
                  }
                  fetch("registrar_computador", {
                      method: "POST",
                      headers: { "Content-Type": "application/x-www-form-urlencoded" },
                      body: "computador_id=" + encodeURIComponent(pcSeleccionado)
                  })
                  .then(response => response.text())
                  .then(data => {
                      console.log("Respuesta:", data);
                      modal.hide();
                  })
                  .catch(error => console.error("Error al registrar computador:", error));
              });
          }
      });

    </script>

    <?php unset($_SESSION['mensaje']); // Limpiar la sesión ?>
<?php endif; ?>