// Verificar si hay datos disponibles
const hasData = ingresosPorHora && ingresosPorHora.length > 0;

// Calcular el total de registros (0 si no hay datos)
const totalRegistros = hasData ? 
    ingresosPorHora.reduce((sum, item) => sum + item.total_ingresos, 0) : 
    0;

// Depuración de datos
console.log("Datos de ingresosPorHora:", ingresosPorHora);
console.log("Total de registros:", totalRegistros);

// Definir horas base (de 6:00 AM a 1:00 AM)
const horas = Array.from({ length: 20 }, (_, i) => {
    const hora = (i + 6) % 24;
    return `${String(hora).padStart(2, '0')}:00`;
});

// Definir roles y colores
const roles = ['Instructor', 'Funcionario', 'Directivo', 'Apoyo', 'Visitante'];
const colores = [
    'rgba(255, 99, 132, 0.6)',
    'rgba(54, 162, 235, 0.6)',
    'rgba(255, 206, 86, 0.6)',
    'rgba(75, 192, 192, 0.6)',
    'rgba(153, 102, 255, 0.6)'
];

// Función para crear gráfico con manejo de datos vacíos
function createChartWithEmptyData(ctx, type, data, labels, backgroundColor, options) {
    // Configuración base para gráficos vacíos
    const emptyData = labels.map(() => 0);
    
    return new Chart(ctx, {
        type: type,
        data: {
            labels: hasData ? labels : ['No hay datos'],
            datasets: [{
                data: hasData ? data : emptyData,
                backgroundColor: backgroundColor,
                borderColor: backgroundColor.map(color => color.replace('0.6', '1')),
                borderWidth: 1
            }]
        },
        options: {
            ...options,
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                ...options.plugins,
                // Plugin para mostrar mensaje cuando no hay datos
                emptyChart: {
                    text: 'No hay datos disponibles',
                    color: '#666',
                    fontStyle: 'italic'
                }
            }
        },
        plugins: [{
            id: 'emptyChart',
            afterDraw(chart) {
                if (!hasData) {
                    const ctx = chart.ctx;
                    const width = chart.width;
                    const height = chart.height;
                    
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.font = 'italic 16px Arial';
                    ctx.fillStyle = '#666';
                    ctx.fillText('No hay datos disponibles', width / 2, height / 2);
                    ctx.restore();
                }
            }
        }]
    });
}

// Calcular datos para gráficos (o usar ceros si no hay datos)
const totalPorRol = hasData ? 
    roles.map(rol => {
        return ingresosPorHora
            .filter(item => item.rol === rol)
            .reduce((sum, item) => sum + item.total_ingresos, 0);
    }) : 
    Array(roles.length).fill(0);

const porcentajeRoles = totalPorRol.map(total => totalRegistros > 0 ? (total / totalRegistros) * 100 : 0);

const personalSena = hasData ? totalPorRol.slice(0, 4).reduce((sum, total) => sum + total, 0) : 0;
const visitantes = hasData ? totalPorRol[4] : 0;
const porcentajeSena = totalRegistros > 0 ? (personalSena / totalRegistros) * 100 : 0;
const porcentajeVisitantes = totalRegistros > 0 ? (visitantes / totalRegistros) * 100 : 0;

// Gráfico de donut para los roles
const ctxRoles = document.getElementById('graficoRoles').getContext('2d');
createChartWithEmptyData(
    ctxRoles, 
    'doughnut', 
    porcentajeRoles, 
    roles, 
    colores,
    {
        plugins: {
            title: {
                display: true,
                text: 'Distribución por Rol',
                font: { size: 10, weight: 'bold' },
                color: '#666'
            },
            legend: {
                labels: {
                    font: { size: 10, weight: 'normal' },
                    color: '#666'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label}: ${context.raw.toFixed(2)}%`;
                    }
                },
                bodyFont: { size: 12 },
                titleFont: { size: 12 }
            }
        }
    }
);

// Gráfico de donut para personal SENA vs. visitantes
const ctxSenaVisitantes = document.getElementById('graficoSenaVisitantes').getContext('2d');
createChartWithEmptyData(
    ctxSenaVisitantes, 
    'doughnut', 
    [porcentajeSena, porcentajeVisitantes], 
    ['Personal SENA', 'Visitantes'], 
    ['rgba(54, 162, 235, 0.6)', 'rgba(153, 102, 255, 0.6)'],
    {
        plugins: {
            title: {
                display: true,
                text: 'Personal SENA vs. Visitantes',
                font: { size: 14, weight: 'bold' },
                color: '#666'
            },
            legend: {
                labels: {
                    font: { size: 12, weight: 'normal' },
                    color: '#666'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label}: ${context.raw.toFixed(2)}%`;
                    }
                },
                bodyFont: { size: 12 },
                titleFont: { size: 12 }
            }
        }
    }
);

// Preparar datasets para gráfico de líneas
const datasets = roles.map((rol, index) => {
    const datosRol = horas.map(hora => {
        if (!hasData) return { x: hora, y: 0, horaExacta: null };
        
        const registros = ingresosPorHora.filter(item => 
            String(item.hora).padStart(2, '0') === hora.split(':')[0] && 
            item.rol === rol
        );

        const totalIngresos = registros.reduce((sum, item) => sum + item.total_ingresos, 0);
        
        return {
            x: hora,
            y: totalIngresos,
            horaExacta: registros.length > 0 ? 
                `${String(registros[0].hora).padStart(2, '0')}:${String(registros[0].minuto).padStart(2, '0')}` : 
                null
        };
    });

    return {
        label: rol,
        data: datosRol,
        backgroundColor: colores[index],
        borderColor: colores[index].replace('0.6', '1'),
        borderWidth: 1,
        tension: 0.4,
        pointRadius: 3,
        pointBackgroundColor: colores[index],
        pointBorderColor: '#fff',
        pointHoverRadius: 5
    };
});

// Configurar líneas horizontales
const intervaloLineas = 5;
const lineasHorizontales = [];
const maxY = hasData ? totalUsuarios : 10; // Valor máximo para el eje Y

for (let i = 0; i <= maxY; i += intervaloLineas) {
    lineasHorizontales.push({
        type: 'line',
        yMin: i,
        yMax: i,
        borderColor: 'rgba(0, 0, 0, 0.2)',
        borderWidth: 1,
        borderDash: [5, 5]
    });
}

// Gráfico de Ingreso por Hora
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
                    font: { size: 12, weight: 'bold' },
                    color: '#666'
                },
                ticks: {
                    autoSkip: false,
                    maxRotation: 90,
                    minRotation: 90,
                    font: { size: 12 },
                    color: '#666'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Cantidad',
                    font: { size: 12, weight: 'bold' },
                    color: '#666'
                },
                ticks: {
                    precision: 0,
                    max: maxY,
                    font: { size: 12 },
                    color: '#666'
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    title: function(context) {
                        const horaExacta = context[0].raw.horaExacta;
                        return horaExacta ? `Hora: ${horaExacta}` : `Hora: ${context[0].label}`;
                    },
                    label: function(context) {
                        return `${context.dataset.label}: ${context.raw.y}`;
                    }
                },
                bodyFont: { size: 12 },
                titleFont: { size: 12 }
            },
            annotation: {
                annotations: lineasHorizontales
            },
            // Plugin para mensaje de no datos
            emptyChart: {
                text: 'No hay datos disponibles',
                color: '#666',
                fontStyle: 'italic'
            }
        },
        elements: {
            line: {
                tension: 0.4
            }
        }
    },
    plugins: [{
        id: 'emptyChart',
        afterDraw(chart) {
            if (!hasData) {
                const ctx = chart.ctx;
                const width = chart.width;
                const height = chart.height;
                
                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = 'italic 16px Arial';
                ctx.fillStyle = '#666';
                ctx.fillText('No hay datos disponibles', width / 2, height / 2);
                ctx.restore();
            }
        }
    }]
});