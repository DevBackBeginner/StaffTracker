<!-- Título con fondo verde al 100% -->
<div class="container-fluid bg-success text-white p-2 mb-3">
    <div class="row">
        <div class="col-12 text-center">
            <h4 class="mb-0">Sistema de Escaneo e Identificación</h4>
        </div>
    </div>
</div>

<!-- Pestañas -->
<div class="container">
    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">
                Escaner
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">
                Identificación
            </button>
        </li>
    </ul>

    <!-- Contenido de las pestañas -->
    <div class="tab-content" id="myTabContent">
        <!-- Pestaña 1 -->
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <form id="form-escaneo" method="POST" onsubmit="event.preventDefault();">
                <div class="mt-2">
                    <label for="codigo" class="form-label fw-bold" style="color: #007832;">Identificación</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" id="codigo" name="codigo" placeholder="Escanea el código aquí" class="form-control" autofocus>
                    </div>
                </div>
            </form>
        </div>

        <!-- Pestaña 2 -->
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <form id="form-escaneo" method="POST" onsubmit="event.preventDefault();">
                <div class="mt-2">
                    <label for="codigo" class="form-label fw-bold" style="color: #007832;">Identificación</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" id="codigo2" placeholder="Ingresa el número de identificación aquí" class="form-control">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>