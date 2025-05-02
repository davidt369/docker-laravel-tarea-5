@extends('layouts.app')

@section('title', 'Gestión de Equipos')

@section('content')
<div class="container">
    <h1 class="my-4">Gestión de Equipos</h1>

    <!-- Mensajes de alerta -->
    <div id="alert-container"></div>

    <!-- Formulario para agregar/editar equipo -->
    <div class="card mb-4">
        <div class="card-header">
            <span id="form-title">Agregar Equipo</span>
        </div>
        <div class="card-body">
            <form id="equipo-form">
                <input type="hidden" id="equipo-id" value="">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="colores" class="form-label">Colores</label>
                    <input type="text" class="form-control" id="colores" name="colores" required>
                </div>
                <button type="submit" class="btn btn-primary" id="btn-save">Guardar</button>
                <button type="button" class="btn btn-secondary" id="btn-cancel" style="display:none;">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Tabla de equipos -->
    <div class="card">
        <div class="card-header">
            Lista de Equipos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="equipos-table" class="table table-striped dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Colores</th>
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

    $(document).ready(function() {
        // Inicializar DataTable
        dataTable = $('#equipos-table').DataTable({
            ajax: {
                url: '/api/equipos',
                dataSrc: ''
            },
            columns: [
                { data: 'id_equipo' },
                { data: 'nombre' },
                {
                    data: 'colores',
                    render: function(data, type, row) {
                        return `<span class="badge bg-primary">${data}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-warning edit-equipo" data-id="${row.id_equipo}">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn btn-sm btn-danger delete-equipo" data-id="${row.id_equipo}">
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
                        dt.ajax.reload();
                    }
                }
            ]
        });

        // Enviar formulario (agregar/actualizar equipo)
        $("#equipo-form").submit(function(e) {
            e.preventDefault();
            guardarEquipo();
        });

        // Botón cancelar edición
        $("#btn-cancel").click(function() {
            resetForm();
        });

        // Delegación de eventos para los botones de acción
        $('#equipos-table').on('click', '.edit-equipo', function() {
            editarEquipo($(this).data('id'));
        });

        $('#equipos-table').on('click', '.delete-equipo', function() {
            eliminarEquipo($(this).data('id'));
        });
    });

    // Función para guardar un equipo (crear o actualizar)
    function guardarEquipo() {
        const equipoId = $("#equipo-id").val();
        const data = {
            nombre: $("#nombre").val(),
            colores: $("#colores").val()
        };

        // Determina si es crear o actualizar
        const url = equipoId ? `/api/equipos/${equipoId}` : '/api/equipos';
        const method = equipoId ? 'PUT' : 'POST';
        const successMsg = equipoId ? 'Equipo actualizado correctamente' : 'Equipo creado correctamente';

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

    // Función para editar un equipo
    function editarEquipo(id) {
        $.ajax({
            url: `/api/equipos/${id}`,
            type: 'GET',
            success: function(equipo) {
                $("#equipo-id").val(equipo.id_equipo);
                $("#nombre").val(equipo.nombre);
                $("#colores").val(equipo.colores);
                $("#form-title").text("Editar Equipo");
                $("#btn-save").text("Actualizar");
                $("#btn-cancel").show();
            },
            error: function(error) {
                mostrarAlerta('Error al cargar el equipo: ' + error.responseJSON.message, 'danger');
            }
        });
    }

    // Función para eliminar un equipo
    function eliminarEquipo(id) {
        if (confirm('¿Está seguro de que desea eliminar este equipo?')) {
            $.ajax({
                url: `/api/equipos/${id}`,
                type: 'DELETE',
                success: function() {
                    mostrarAlerta('Equipo eliminado correctamente', 'success');
                    dataTable.ajax.reload();
                },
                error: function(error) {
                    mostrarAlerta('Error al eliminar el equipo: ' + error.responseJSON.message, 'danger');
                }
            });
        }
    }

    // Función para resetear el formulario
    function resetForm() {
        $("#equipo-id").val("");
        $("#nombre").val("");
        $("#colores").val("");
        $("#form-title").text("Agregar Equipo");
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
