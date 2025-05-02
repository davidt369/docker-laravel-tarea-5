@extends('layouts.app')

@section('title', 'Gestión de Jugadores')

@section('content')
<div class="container">
    <h1 class="my-4">Gestión de Jugadores</h1>

    <!-- Mensajes de alerta -->
    <div id="alert-container"></div>

    <!-- Formulario para agregar/editar jugador -->
    <div class="card mb-4">
        <div class="card-header">
            <span id="form-title">Agregar Jugador</span>
        </div>
        <div class="card-body">
            <form id="jugador-form">
                <input type="hidden" id="jugador-id" value="">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="puesto" class="form-label">Puesto</label>
                    <select class="form-select" id="puesto" name="puesto" required>
                        <option value="">Seleccione un puesto</option>
                        <option value="Portero">Portero</option>
                        <option value="Defensa">Defensa</option>
                        <option value="Mediocampista">Mediocampista</option>
                        <option value="Delantero">Delantero</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pierna" class="form-label">Pierna Dominante</label>
                    <select class="form-select" id="pierna" name="pierna" required>
                        <option value="">Seleccione la pierna dominante</option>
                        <option value="Derecha">Derecha</option>
                        <option value="Izquierda">Izquierda</option>
                        <option value="Ambas">Ambas</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="btn-save">Guardar</button>
                <button type="button" class="btn btn-secondary" id="btn-cancel" style="display:none;">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Tabla de jugadores -->
    <div class="card">
        <div class="card-header">
            Lista de Jugadores
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="jugadores-table" class="table table-striped dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th>Pierna Dominante</th>
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
        dataTable = $('#jugadores-table').DataTable({
            ajax: {
                url: '/api/jugadores',
                dataSrc: ''
            },
            columns: [
                { data: 'id_jugador' },
                { data: 'nombre' },
                { data: 'puesto' },
                { data: 'pierna' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-warning edit-jugador" data-id="${row.id_jugador}">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn btn-sm btn-danger delete-jugador" data-id="${row.id_jugador}">
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
            ],
            columnDefs: [
                {
                    targets: 2, // Columna de Puesto
                    render: function(data, type, row) {
                        const badgeClass = {
                            'Portero': 'bg-info',
                            'Defensa': 'bg-success',
                            'Mediocampista': 'bg-warning',
                            'Delantero': 'bg-danger'
                        }[data] || 'bg-secondary';

                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    }
                }
            ]
        });

        // Enviar formulario (agregar/actualizar jugador)
        $("#jugador-form").submit(function(e) {
            e.preventDefault();
            guardarJugador();
        });

        // Botón cancelar edición
        $("#btn-cancel").click(function() {
            resetForm();
        });

        // Delegación de eventos para los botones de acción
        $('#jugadores-table').on('click', '.edit-jugador', function() {
            editarJugador($(this).data('id'));
        });

        $('#jugadores-table').on('click', '.delete-jugador', function() {
            eliminarJugador($(this).data('id'));
        });
    });

    // Función para guardar un jugador (crear o actualizar)
    function guardarJugador() {
        const jugadorId = $("#jugador-id").val();
        const data = {
            nombre: $("#nombre").val(),
            puesto: $("#puesto").val(),
            pierna: $("#pierna").val()
        };

        // Determina si es crear o actualizar
        const url = jugadorId ? `/api/jugadores/${jugadorId}` : '/api/jugadores';
        const method = jugadorId ? 'PUT' : 'POST';
        const successMsg = jugadorId ? 'Jugador actualizado correctamente' : 'Jugador creado correctamente';

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

    // Función para editar un jugador
    function editarJugador(id) {
        $.ajax({
            url: `/api/jugadores/${id}`,
            type: 'GET',
            success: function(jugador) {
                $("#jugador-id").val(jugador.id_jugador);
                $("#nombre").val(jugador.nombre);
                $("#puesto").val(jugador.puesto);
                $("#pierna").val(jugador.pierna);
                $("#form-title").text("Editar Jugador");
                $("#btn-save").text("Actualizar");
                $("#btn-cancel").show();
            },
            error: function(error) {
                mostrarAlerta('Error al cargar el jugador: ' + error.responseJSON.message, 'danger');
            }
        });
    }

    // Función para eliminar un jugador
    function eliminarJugador(id) {
        if (confirm('¿Está seguro de que desea eliminar este jugador?')) {
            $.ajax({
                url: `/api/jugadores/${id}`,
                type: 'DELETE',
                success: function() {
                    mostrarAlerta('Jugador eliminado correctamente', 'success');
                    dataTable.ajax.reload();
                },
                error: function(error) {
                    mostrarAlerta('Error al eliminar el jugador: ' + error.responseJSON.message, 'danger');
                }
            });
        }
    }

    // Función para resetear el formulario
    function resetForm() {
        $("#jugador-id").val("");
        $("#nombre").val("");
        $("#puesto").val("");
        $("#pierna").val("");
        $("#form-title").text("Agregar Jugador");
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
