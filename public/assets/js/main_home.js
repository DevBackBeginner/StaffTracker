function cambiarFiltro(filtro) {
    // Configurar los datos para enviar en la solicitud POST
    const datos = {
        filtro: filtro
    };

    // Realizar una solicitud AJAX al servidor usando POST
    fetch('obtenerdatosD/S/M', {
        method: 'POST', // Usar el método POST
        headers: {
            'Content-Type': 'application/json' // Indicar que el cuerpo es JSON
        },
        body: JSON.stringify(datos) // Convertir los datos a JSON
    })
    .then(response => response.json())
    .then(data => {
        // Actualizar los datos en la página
        let totalRegistros = document.getElementById('total-registros');
        let filtroActivo = document.getElementById('filtro-activo');
        let porcentajeAumento = document.getElementById('porcentaje-aumento');
        let textoAumento = document.getElementById('texto-aumento');

        // Actualizar el total de registros
        totalRegistros.textContent = data.total;

        // Actualizar el porcentaje de aumento
        porcentajeAumento.textContent = `${data.porcentajeAumento}%`;

        // Cambiar el texto del filtro activo
        switch (filtro) {
            case 'diarios':
                filtroActivo.textContent = '| Diarios';
                break;
            case 'semanales':
                filtroActivo.textContent = '| Semanales';
                break;
            case 'mensuales':
                filtroActivo.textContent = '| Mensuales';
                break;
        }

        // Cambiar el texto "aumento" o "disminución" según el porcentaje
        if (data.porcentajeAumento >= 0) {
            textoAumento.textContent = 'aumento';
            porcentajeAumento.classList.remove('text-danger');
            porcentajeAumento.classList.add('text-success');
        } else {
            textoAumento.textContent = 'disminución';
            porcentajeAumento.classList.remove('text-success');
            porcentajeAumento.classList.add('text-danger');
        }
    })
    .catch(error => console.error('Error:', error));
}