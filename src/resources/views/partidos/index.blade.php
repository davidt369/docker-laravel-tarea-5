@extends('layouts.app')

@section('title', 'Gestión de Partidos')

@section('content')
<div class="container">
    <h1 class="my-4">Gestión de Partidos</h1>

    <!-- Mensajes de alerta -->
    <div id="alert-container"></div>

    <!-- Formulario para agregar/editar partido -->
    <div class="card mb-4">
        <div class="card-header">
            <span id="form-title">Agregar Partido</span>
        </div>
        <div class="card-body">
            <form id="partido-form">
                <input type="hidden" id="partido-id" value="">
                <div class="mb-3">
                    <label for="id_equipo_local" class="form-label">Equipo Local</label>
                    <select class="form-select" id="id_equipo_local" name="id_equipo_local" required>
                        <option value="">Seleccione el equipo local</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="id_equipo_visitante" class="form-label">Equipo Visitante</label>
                    <select class="form-select" id="id_equipo_visitante" name="id_equipo_visitante" required>
                        <option value="">Seleccione el equipo visitante</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="resultado" class="form-label">Resultado</label>
                    <input type="text" class="form-control" id="resultado" name="resultado" placeholder="Ej: 2-1">
                </div>
                <button type="submit" class="btn btn-primary" id="btn-save">Guardar</button>
                <button type="button" class="btn btn-secondary" id="btn-cancel" style="display:none;">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Tabla de partidos -->
    <div class="card">
        <div class="card-header">
            Lista de Partidos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="partidos-table" class="table table-striped dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Equipo Local</th>
                            <th>Equipo Visitante</th>
                            <th>Resultado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let dataTable;
    let equipos = [];

    $(document).ready(function() {
        // Cargar los equipos primero
        cargarEquipos().then(() => {
            // Después de cargar los equipos, inicializar DataTable
            inicializarDataTable();
        });

        // Validar que no se seleccione el mismo equipo como local y visitante
        $("#id_equipo_local, #id_equipo_visitante").change(function() {
            const local = $("#id_equipo_local").val();
            const visitante = $("#id_equipo_visitante").val();

            if (local && visitante && local === visitante) {
                mostrarAlerta('El equipo local y visitante no pueden ser el mismo', 'warning');
                $(this).val('');
            }
        });

        // Enviar formulario (agregar/actualizar partido)
        $("#partido-form").submit(function(e) {
            e.preventDefault();
            guardarPartido();
        });

        // Botón cancelar edición
        $("#btn-cancel").click(function() {
            resetForm();
        });

        // Delegación de eventos para los botones de acción
        $('#partidos-table').on('click', '.edit-partido', function() {
            editarPartido($(this).data('id'));
        });

        $('#partidos-table').on('click', '.delete-partido', function() {
            eliminarPartido($(this).data('id'));
        });
    });

    // Función para cargar los equipos
    function cargarEquipos() {
        return $.ajax({
            url: '/api/equipos',
            type: 'GET',
            success: function(data) {
                equipos = data;
                let options = '<option value="">Seleccione el equipo</option>';
                equipos.forEach(equipo => {
                    options += `<option value="${equipo.id_equipo}">${equipo.nombre}</option>`;
                });
                $("#id_equipo_local, #id_equipo_visitante").html(options);
            },
            error: function(error) {
                mostrarAlerta('Error al cargar los equipos: ' + error.responseJSON.message, 'danger');
            }
        });
    }

    // Función para inicializar DataTable
    function inicializarDataTable() {
        dataTable = $('#partidos-table').DataTable({
            ajax: {
                url: '/api/partidos',
                dataSrc: ''
            },
            columns: [
                { data: 'id_partido' },
                {
                    data: 'equipo_local',
                    render: function(data, type, row) {
                        return data ? data.nombre : '';
                    }
                },
                {
                    data: 'equipo_visitante',
                    render: function(data, type, row) {
                        return data ? data.nombre : '';
                    }
                },
                {
                    data: 'resultado',
                    render: function(data, type, row) {
                        return data ? `<span class="badge bg-success">${data}</span>` :
                                    '<span class="badge bg-secondary">Pendiente</span>';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-warning edit-partido" data-id="${row.id_partido}">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn btn-sm btn-danger delete-partido" data-id="${row.id_partido}">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        `;
                    }
                }
            ],
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '<i class="fas fa-sync-alt"></i> Actualizar',
                    className: 'btn btn-info',
                    action: function (e, dt, node, config) {
                        cargarEquipos().then(() => {
                            dt.ajax.reload();
                        });
                    }
                }
            ]
        });
    }

    // Función para guardar un partido
    function guardarPartido() {
        const partidoId = $("#partido-id").val();
        const local = $("#id_equipo_local").val();
        const visitante = $("#id_equipo_visitante").val();

        if (local === visitante) {
            mostrarAlerta('El equipo local y visitante no pueden ser el mismo', 'warning');
            return;
        }

        const data = {
            id_equipo_local: local,
            id_equipo_visitante: visitante,
            resultado: $("#resultado").val()
        };

        // Determina si es crear o actualizar
        const url = partidoId ? `/api/partidos/${partidoId}` : '/api/partidos';
        const method = partidoId ? 'PUT' : 'POST';
        const successMsg = partidoId ? 'Partido actualizado correctamente' : 'Partido creado correctamente';

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                mostrarAlerta(successMsg, 'success');
                resetForm();
                dataTable.ajax.reload();
            },
            error: function(error) {
                mostrarAlerta('Error: ' + error.responseJSON.message, 'danger');
            }
        });
    }


    function editarPartido(id) {
        $.ajax({
            url: `/api/partidos/${id}`,
            type: 'GET',
            success: function(partido) {
                $("#partido-id").val(partido.id_partido);
                $("#id_equipo_local").val(partido.id_equipo_local);
                $("#id_equipo_visitante").val(partido.id_equipo_visitante);
                $("#resultado").val(partido.resultado);
                $("#form-title").text("Editar Partido");
                $("#btn-save").text("Actualizar");
                $("#btn-cancel").show();
            },
            error: function(error) {
                mostrarAlerta('Error al cargar el partido: ' + error.responseJSON.message, 'danger');
            }
        });
    }


    function eliminarPartido(id) {
        if (confirm('¿Está seguro de que desea eliminar este partido?')) {
            $.ajax({
                url: `/api/partidos/${id}`,
                type: 'DELETE',
                success: function() {
                    mostrarAlerta('Partido eliminado correctamente', 'success');
                    dataTable.ajax.reload();
                },
                error: function(error) {
                    mostrarAlerta('Error al eliminar el partido: ' + error.responseJSON.message, 'danger');
                }
            });
        }
    }

    // Función para resetear el formulario
    function resetForm() {
        $("#partido-id").val("");
        $("#id_equipo_local").val("");
        $("#id_equipo_visitante").val("");
        $("#resultado").val("");
        $("#form-title").text("Agregar Partido");
        $("#btn-save").text("Guardar");
        $("#btn-cancel").hide();
    }

    // Función para mostrar alertas
    function mostrarAlerta(mensaje, tipo) {
        const alert = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        $("#alert-container").html(alert);

        // Auto-cerrar después de 5 segundos
        setTimeout(function() {
            $(".alert").alert('close');
        }, 5000);
    }
</script>
@endpush
