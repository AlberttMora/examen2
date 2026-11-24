document.addEventListener('DOMContentLoaded', function () {
    const contenedor = document.getElementById('lista-publica');
    if (!contenedor) return;

    const token = contenedor.dataset.token;
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const contador = document.getElementById('contador');
    const porcentajeTxt = document.getElementById('porcentaje');
    const barra = document.getElementById('barra');
    const mensajeExito = document.getElementById('mensaje-exito');

    // Contador, porcentaje, barra y mensaje de éxito
    function pintarProgreso(completados, total, porcentaje) {
        contador.textContent = completados + ' de ' + total + ' completados';
        porcentajeTxt.textContent = porcentaje + '%';
        barra.style.width = porcentaje + '%';
        barra.setAttribute('aria-valuenow', porcentaje);

        if (total > 0 && completados === total) {
            mensajeExito.classList.remove('d-none');
        } else {
            mensajeExito.classList.add('d-none');
        }
    }

    // Estado y tachado de un ítem
    function pintarEstado(checkbox) {
        const li = checkbox.closest('li');
        li.querySelector('.item-estado').textContent = checkbox.checked ? 'Completado' : 'Pendiente';
        li.querySelector('.item-texto').classList.toggle('text-decoration-line-through', checkbox.checked);
        li.querySelector('.item-texto').classList.toggle('text-muted', checkbox.checked);
    }

    document.querySelectorAll('.item-check').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const id = checkbox.dataset.id;
            const marcado = checkbox.checked;

            checkbox.disabled = true;

            fetch('/' + token + '/items/' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ completado: marcado })
            })
                .then(function (respuesta) {
                    if (!respuesta.ok) throw new Error('HTTP ' + respuesta.status);
                    return respuesta.json();
                })
                .then(function (datos) {
                    pintarEstado(checkbox);
                    pintarProgreso(datos.completados, datos.total, datos.porcentaje);
                })
                .catch(function () {
                    checkbox.checked = !marcado; // revierte si no se guardó
                    alert('No se pudo guardar el cambio. Intentá de nuevo.');
                })
                .finally(function () {
                    checkbox.disabled = false;
                });
        });
    });

    // Estado inicial
    document.querySelectorAll('.item-check').forEach(pintarEstado);
    const total = document.querySelectorAll('.item-check').length;
    const completados = document.querySelectorAll('.item-check:checked').length;
    const porcentaje = total > 0 ? Math.round((completados / total) * 100) : 0;
    pintarProgreso(completados, total, porcentaje);
});