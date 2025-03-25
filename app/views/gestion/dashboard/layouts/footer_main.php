<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<footer class="footer py-5 bg-light">
    <div class="container"> <!-- Contenedor agregado -->
        <div id="carouselFooter" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-home"></i> Inicio</h3>
                            <p>En la sección Inicio, se muestra el panel de control, permitiendo a los usuarios visualizar información clave del sistema. Se pueden consultar los registros de los usuarios, funcionarios y visitantes.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-user-shield"></i> Registrar Guardas</h3>
                            <p>La sección Registrar Guardas permite la incorporación de nuevos guardas al sistema, ingresando sus datos personales y asignándoles acceso específico.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-users"></i> Gestión de Usuarios</h3>
                            <p>En la sección Gestión de Usuarios, se pueden registrar instructores no registrados, facilitando su integración. Ofrece opciones para consultar usuarios registrados.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-file-alt"></i> Reportes</h3>
                            <p>La sección Reportes permite obtener un seguimiento detallado de la actividad dentro del sistema, generando reportes diarios y mensuales.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-chart-line"></i> Reportes Gráficos</h3>
                            <p>En la sección Reportes Gráficos, los usuarios visualizarán de forma interactiva los reportes generados y presentados gráficamente.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-center align-items-center h-100 p-4" style="height: 300px;">
                        <div class="text-center">
                            <h3 class="text-success"><i class="fas fa-user"></i> Perfil</h3>
                            <p>En la sección Perfil, los usuarios podrán acceder a la información detallada de su cuenta en el sistema. Aquí, podrán ver y gestionar sus datos personales, como su nombre, correo electrónico, y otros detalles relevantes. Además, tendrán la posibilidad de editar esta información en caso de que necesiten actualizarla. Esta sección también incluye una opción para cambiar la contraseña, garantizando que los usuarios puedan mantener la seguridad de su cuenta. Los usuarios podrán actualizar su foto de perfil, cambiando la imagen asociada a su cuenta, lo que les permite personalizar su presencia dentro del sistema. La sección de Perfil es esencial para que los usuarios mantengan su información actualizada y segura, brindando un control total sobre sus datos y preferencias.</p>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselFooter" data-bs-slide="prev" aria-label="Previous">
                <span class="carousel-control-prev-icon bg-success" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselFooter" data-bs-slide="next" aria-label="Next">
                <span class="carousel-control-next-icon bg-success" aria-hidden="true"></span>
            </button>
        </div>
    </div> <!-- Fin del contenedor -->
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .carousel {
        position: relative;
    }
    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        padding: 0.5rem;
    }
</style>
