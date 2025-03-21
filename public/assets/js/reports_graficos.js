
// Calcular el total de registros (suma de todos los registros en ingresosPorHora)
const totalRegistros = ingresosPorHora.reduce((sum, item) => sum + item.total_ingresos, 0);

// Depura los datos en JavaScript
console.log("Datos de ingresosPorHora:", ingresosPorHora);
console.log("Total de registros:", totalRegistros);

// Definir las horas de 6:00 AM a 1:00 AM
const horas = Array.from({ length: 20 }, (_, i) => {
    const hora = (i + 6) % 24; // Horas de 6 a 23, luego 0 y 1
    return `${String(hora).padStart(2, '0')}:00`; // Formato HH:00
});

// Definir roles a incluir en el gráfico
const roles = ['Instructor', 'Funcionario', 'Directivo', 'Apoyo', 'Visitante'];
const colores = [
    'rgba(255, 99, 132, 0.6)', // Rojo
    'rgba(54, 162, 235, 0.6)', // Azul
    'rgba(255, 206, 86, 0.6)', // Amarillo
    'rgba(75, 192, 192, 0.6)', // Verde
    'rgba(153, 102, 255, 0.6)' // Morado (Visitante)
];

// Calcular el total de ingresos por rol
const totalPorRol = roles.map(rol => {
    return ingresosPorHora
        .filter(item => item.rol === rol)
        .reduce((sum, item) => sum + item.total_ingresos, 0);
});

// Calcular el porcentaje de cada rol basado en el total de registros
const porcentajeRoles = totalPorRol.map(total => (total / totalRegistros) * 100);

// Calcular el total de personal SENA y visitantes
const personalSena = totalPorRol.slice(0, 4).reduce((sum, total) => sum + total, 0); // Suma de los primeros 4 roles
const visitantes = totalPorRol[4]; // Visitantes
const porcentajeSena = (personalSena / totalRegistros) * 100;
const porcentajeVisitantes = (visitantes / totalRegistros) * 100;

// Gráfico de donut para los roles
const ctxRoles = document.getElementById('graficoRoles').getContext('2d');
new Chart(ctxRoles, {
    type: 'doughnut',
    data: {
        labels: roles,
        datasets: [{
            data: porcentajeRoles, // Porcentajes basados en el total de registros
            backgroundColor: colores,
            borderColor: colores.map(color => color.replace('0.6', '1')),
            borderWidth: 1
        }]
    },
    options: {
        responsive: true, // Hace que el gráfico sea responsivo
        maintainAspectRatio: false, // Permite ajustar el tamaño manualmente
        plugins: {
            title: {
                display: true,
                text: 'Distribución por Rol',
                font: {
                    size: 10, // Tamaño de la letra reducido
                    weight: 'bold' // Negrita
                },
                color: '#666' // Color suave
            },
            legend: {
                labels: {
                    font: {
                        size: 10, // Tamaño de la letra reducido
                        weight: 'normal'
                    },
                    color: '#666' // Color suave
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label}: ${context.raw.toFixed(2)}%`; // Muestra el porcentaje en el tooltip
                    }
                },
                bodyFont: {
                    size: 12 // Tamaño de la letra reducido en el tooltip
                },
                titleFont: {
                    size: 12 // Tamaño de la letra reducido en el tooltip
                }
            }
        }
    }
});

// Gráfico de donut para personal SENA vs. visitantes
const ctxSenaVisitantes = document.getElementById('graficoSenaVisitantes').getContext('2d');
new Chart(ctxSenaVisitantes, {
    type: 'doughnut',
    data: {
        labels: ['Personal SENA', 'Visitantes'],
        datasets: [{
            data: [porcentajeSena, porcentajeVisitantes], // Porcentajes basados en el total de registros
            backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(153, 102, 255, 0.6)'],
            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(153, 102, 255, 1)'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true, // Hace que el gráfico sea responsivo
        maintainAspectRatio: false, // Permite ajustar el tamaño manualmente
        plugins: {
            title: {
                display: true,
                text: 'Personal SENA vs. Visitantes',
                font: {
                    size: 14, // Tamaño de la letra reducido
                    weight: 'bold' // Negrita
                },
                color: '#666' // Color suave
            },
            legend: {
                labels: {
                    font: {
                        size: 12, // Tamaño de la letra reducido
                        weight: 'normal'
                    },
                    color: '#666' // Color suave
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label}: ${context.raw.toFixed(2)}%`; // Muestra el porcentaje en el tooltip
                    }
                },
                bodyFont: {
                    size: 12 // Tamaño de la letra reducido en el tooltip
                },
                titleFont: {
                    size: 12 // Tamaño de la letra reducido en el tooltip
                }
            }
        }
    }
});

// Preparar datasets para cada rol (gráfico de líneas)
const datasets = roles.map((rol, index) => {
    const datosRol = horas.map(hora => {
        // Buscar registros que coincidan con la hora y el rol
        const registros = ingresosPorHora.filter(item => 
            String(item.hora).padStart(2, '0') === hora.split(':')[0] && 
            item.rol === rol
        );

        // Sumar los ingresos para esta hora y rol
        const totalIngresos = registros.reduce((sum, item) => sum + item.total_ingresos, 0);

        return {
            x: hora, // Hora completa (sin minutos)
            y: totalIngresos, // Cantidad de ingresos
            horaExacta: registros.length > 0 ? `${String(registros[0].hora).padStart(2, '0')}:${String(registros[0].minuto).padStart(2, '0')}` : null // Hora exacta con minutos
        };
    });

    return {
        label: rol,
        data: datosRol,
        backgroundColor: colores[index],
        borderColor: colores[index].replace('0.6', '1'), // Borde más oscuro
        borderWidth: 1,
        tension: 0.4, // Curvas suaves
        pointRadius: 3, // Tamaño de los puntos reducido
        pointBackgroundColor: colores[index], // Color de los puntos
        pointBorderColor: '#fff', // Borde de los puntos
        pointHoverRadius: 5 // Tamaño de los puntos al hacer hover
    };
});

// Configurar las líneas horizontales
const intervaloLineas = 5; // Intervalo entre líneas (cada 5 unidades)
const lineasHorizontales = [];
for (let i = 0; i <= totalUsuarios; i += intervaloLineas) {
    lineasHorizontales.push({
        type: 'line',
        yMin: i,
        yMax: i,
        borderColor: 'rgba(0, 0, 0, 0.2)', // Color de la línea
        borderWidth: 1, // Grosor de la línea
        borderDash: [5, 5] // Línea punteada
    });
}

// Gráfico de Ingreso por Hora con 5 Roles
const ctxIngreso = document.getElementById('graficoIngreso').getContext('2d');
new Chart(ctxIngreso, {
    type: 'line',
    data: {
        labels: horas,
        datasets: datasets
    },
    options: {
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Hora del Día',
                    font: {
                        size: 12, // Tamaño de la letra reducido
                        weight: 'bold'
                    },
                    color: '#666' // Color suave
                },
                ticks: {
                    autoSkip: false, // Muestra todas las etiquetas
                    maxRotation: 90, // Rota las etiquetas para mejor visualización
                    minRotation: 90,
                    font: {
                        size: 12 // Tamaño de la letra reducido
                    },
                    color: '#666' // Color suave
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Cantidad',
                    font: {
                        size: 12, // Tamaño de la letra reducido
                        weight: 'bold'
                    },
                    color: '#666' // Color suave
                },
                ticks: {
                    precision: 0, // Sin decimales
                    max: totalUsuarios, // Establecer el máximo como el total de usuarios
                    font: {
                        size: 12 // Tamaño de la letra reducido
                    },
                    color: '#666' // Color suave
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    title: function(context) {
                        // Mostrar la hora exacta con minutos en el tooltip
                        const horaExacta = context[0].raw.horaExacta;
                        return `Hora: ${horaExacta}`;
                    },
                    label: function(context) {
                        return `${context.dataset.label}: ${context.raw.y}`;
                    }
                },
                bodyFont: {
                    size: 12 // Tamaño de la letra reducido en el tooltip
                },
                titleFont: {
                    size: 12 // Tamaño de la letra reducido en el tooltip
                }
            },
            // Configurar las líneas horizontales
            annotation: {
                annotations: lineasHorizontales // Agregar las líneas generadas
            }
        },
        elements: {
            line: {
                tension: 0.4 // Activa la curvatura de las líneas
            }
        }
    }
});