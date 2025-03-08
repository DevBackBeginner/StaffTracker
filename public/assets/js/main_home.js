document.addEventListener('DOMContentLoaded', function () {
    // Selecciona todos los enlaces de filtro
    const filterLinks = document.querySelectorAll('.filter-link');

    // Agrega un evento de clic a cada enlace
    filterLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault(); // Evita que el enlace recargue la página

            // Obtiene el valor del filtro desde el atributo data-filter
            const filtro = this.getAttribute('data-filter');

            // Determina el tipo de tarjeta (registros, funcionarios, visitantes)
            const tipo = this.closest('.card').classList.contains('sales-card') ? 'registros' :
                        this.closest('.card').classList.contains('revenue-card') ? 'funcionarios' :
                        'visitantes';

            // Realiza una solicitud AJAX para obtener los datos filtrados
            fetch('obtenerdatosfiltrados', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ filtro: filtro })
            })
            .then(response => response.json())
            .then(data => {
                // Actualiza los elementos dinámicos según el tipo de tarjeta
                switch (tipo) {
                    case 'registros':
                        actualizarTarjetaRegistros(data, filtro);
                        break;
                    case 'funcionarios':
                        actualizarTarjetaFuncionarios(data, filtro);
                        break;
                    case 'visitantes':
                        actualizarTarjetaVisitantes(data, filtro);
                        break;
                }
            })
            .catch(error => {
                console.error('Error al obtener los datos filtrados:', error);
            });
        });
    });

    /**
     * Actualiza la tarjeta de Registros con los datos recibidos.
     */
    function actualizarTarjetaRegistros(data, filtro) {
        const totalRegistros = document.getElementById('total-registros');
        const porcentajeAumentoRegistros = document.getElementById('porcentaje-aumento-registros');
        const textoAumentoRegistros = document.getElementById('texto-aumento-registros');
        const filtroActivoRegistros = document.getElementById('filtro-activo-registros');

        // Actualiza los valores
        totalRegistros.textContent = data.total;
        porcentajeAumentoRegistros.textContent = `${data.porcentajeAumento}%`;
        textoAumentoRegistros.textContent = (data.porcentajeAumento >= 0) ? 'aumento' : 'disminución';

        // Cambia el color del porcentaje
        if (data.porcentajeAumento >= 0) {
            porcentajeAumentoRegistros.classList.remove('text-danger');
            porcentajeAumentoRegistros.classList.add('text-success');
        } else {
            porcentajeAumentoRegistros.classList.remove('text-success');
            porcentajeAumentoRegistros.classList.add('text-danger');
        }

        // Actualiza el título del filtro activo
        switch (filtro) {
            case 'diarios':
                filtroActivoRegistros.textContent = '| Diarios';
                break;
            case 'semanales':
                filtroActivoRegistros.textContent = '| Semanales';
                break;
            case 'mensuales':
                filtroActivoRegistros.textContent = '| Mensuales';
                break;
        }
    }

    /**
     * Actualiza la tarjeta de Funcionarios con los datos recibidos.
     */
    function actualizarTarjetaFuncionarios(data, filtro) {
        const totalFuncionarios = document.getElementById('total-funcionarios');
        const porcentajeAumentoFuncionarios = document.getElementById('porcentaje-aumento-funcionarios');
        const textoAumentoFuncionarios = document.getElementById('texto-aumento-funcionarios');
        const filtroActivoFuncionarios = document.getElementById('filtro-activo-funcionarios');

        // Actualiza los valores
        totalFuncionarios.textContent = data.total;
        porcentajeAumentoFuncionarios.textContent = `${data.porcentajeAumento}%`;
        textoAumentoFuncionarios.textContent = (data.porcentajeAumento >= 0) ? 'aumento' : 'disminución';

        // Cambia el color del porcentaje
        if (data.porcentajeAumento >= 0) {
            porcentajeAumentoFuncionarios.classList.remove('text-danger');
            porcentajeAumentoFuncionarios.classList.add('text-success');
        } else {
            porcentajeAumentoFuncionarios.classList.remove('text-success');
            porcentajeAumentoFuncionarios.classList.add('text-danger');
        }

        // Actualiza el título del filtro activo
        switch (filtro) {
            case 'funcionarios_diarios':
                filtroActivoFuncionarios.textContent = '| Diarios';
                break;
            case 'funcionarios_semanales':
                filtroActivoFuncionarios.textContent = '| Semanales';
                break;
            case 'funcionarios_mensuales':
                filtroActivoFuncionarios.textContent = '| Mensuales';
                break;
        }
    }

    /**
     * Actualiza la tarjeta de Visitantes con los datos recibidos.
     */
    function actualizarTarjetaVisitantes(data, filtro) {
        const totalVisitantes = document.getElementById('total-visitantes');
        const porcentajeAumentoVisitantes = document.getElementById('porcentaje-aumento-visitantes');
        const textoAumentoVisitantes = document.getElementById('texto-aumento-visitantes');
        const filtroActivoVisitantes = document.getElementById('filtro-activo-visitantes');

        // Actualiza los valores
        totalVisitantes.textContent = data.total;
        porcentajeAumentoVisitantes.textContent = `${data.porcentajeAumento}%`;
        textoAumentoVisitantes.textContent = (data.porcentajeAumento >= 0) ? 'aumento' : 'disminución';

        // Cambia el color del porcentaje
        if (data.porcentajeAumento >= 0) {
            porcentajeAumentoVisitantes.classList.remove('text-danger');
            porcentajeAumentoVisitantes.classList.add('text-success');
        } else {
            porcentajeAumentoVisitantes.classList.remove('text-success');
            porcentajeAumentoVisitantes.classList.add('text-danger');
        }

        // Actualiza el título del filtro activo
        switch (filtro) {
            case 'visitantes_diarios':
                filtroActivoVisitantes.textContent = '| Diarios';
                break;
            case 'visitantes_semanales':
                filtroActivoVisitantes.textContent = '| Semanales';
                break;
            case 'visitantes_mensuales':
                filtroActivoVisitantes.textContent = '| Mensuales';
                break;
        }
    }
});