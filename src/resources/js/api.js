// Funciones API para Equipos
const apiEquipos = {
    obtenerTodos: () => {
        return $.ajax({
            url: "/api/equipos",
            method: "GET",
            dataType: "json",
        });
    },

    obtenerPorId: (id) => {
        return $.ajax({
            url: `/api/equipos/${id}`,
            method: "GET",
            dataType: "json",
        });
    },

    crear: (datos) => {
        return $.ajax({
            url: "/api/equipos",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            dataType: "json",
        });
    },

    actualizar: (id, datos) => {
        return $.ajax({
            url: `/api/equipos/${id}`,
            method: "PUT",
            contentType: "application/json",
            data: JSON.stringify(datos),
            dataType: "json",
        });
    },

    eliminar: (id) => {
        return $.ajax({
            url: `/api/equipos/${id}`,
            method: "DELETE",
        }).then(() => true);
    },
};

// Funciones API para Jugadores
const apiJugadores = {
    obtenerTodos: () => {
        return $.ajax({
            url: "/api/jugadores",
            method: "GET",
            dataType: "json",
        });
    },

    obtenerPorId: (id) => {
        return $.ajax({
            url: `/api/jugadores/${id}`,
            method: "GET",
            dataType: "json",
        });
    },

    crear: (datos) => {
        return $.ajax({
            url: "/api/jugadores",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            dataType: "json",
        });
    },

    actualizar: (id, datos) => {
        return $.ajax({
            url: `/api/jugadores/${id}`,
            method: "PUT",
            contentType: "application/json",
            data: JSON.stringify(datos),
            dataType: "json",
        });
    },

    eliminar: (id) => {
        return $.ajax({
            url: `/api/jugadores/${id}`,
            method: "DELETE",
        }).then(() => true);
    },
};

// Funciones API para Partidos
const apiPartidos = {
    obtenerTodos: () => {
        return $.ajax({
            url: "/api/partidos",
            method: "GET",
            dataType: "json",
        });
    },

    obtenerPorId: (id) => {
        return $.ajax({
            url: `/api/partidos/${id}`,
            method: "GET",
            dataType: "json",
        });
    },

    crear: (datos) => {
        return $.ajax({
            url: "/api/partidos",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            dataType: "json",
        });
    },

    actualizar: (id, datos) => {
        return $.ajax({
            url: `/api/partidos/${id}`,
            method: "PUT",
            contentType: "application/json",
            data: JSON.stringify(datos),
            dataType: "json",
        });
    },

    eliminar: (id) => {
        return $.ajax({
            url: `/api/partidos/${id}`,
            method: "DELETE",
        }).then(() => true);
    },
};

export { apiEquipos, apiJugadores, apiPartidos };
