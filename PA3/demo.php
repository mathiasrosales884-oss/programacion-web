<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
</head>

<body class="p-4">

   
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border border-secondary">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        Actualización de Producto
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 id="idActualizar" class="text-center"></h6>
                    <br />
                    <form id="modalForm">
                        <input type="text" id="nomActualizar" name="nombre" class="form-control border"
                            placeholder="Escribe el nombre a actualizar" />
                        <br />
                        <input type="number" id="precioActualizar" name="precio" class="form-control border"
                            placeholder="Escribe el precio a actualizar" />
                        <br />
                        <input type="number" id="stockActualizar" name="stock" class="form-control border"
                            placeholder="Escribe el stock a actualizar" />
                    </form>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary border" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button onclick="ActualizarDatos()" type="button" class="btn btn-primary border">
                        Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="border rounded p-3 mb-4">
        <h1>BASE DE DATOS</h1>

        <form id="miFormulario" class="d-flex gap-2">
            <input type="text" name="nombre" class="form-control border" placeholder="Nombre" required>
            <input type="number" name="precio" class="form-control border" placeholder="precio" required>
            <input type="number" name="stock" class="form-control border" placeholder="Stock" required>
            <button type="submit" class="btn btn-primary border">Crear</button>
        </form>
    </div>

    
    <table id="miTabla" class="table table-bordered"></table>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const idActualizar = document.getElementById("idActualizar");
            const nomActualizar = document.getElementById("nomActualizar");
            const precioActualizar = document.getElementById("precioActualizar");
            const stockActualizar = document.getElementById("stockActualizar");

            const miTabla = document.getElementById("miTabla");
            const miFormulario = document.getElementById("miFormulario");

            const MyFetch = async (url) => {
                try {
                    const respuesta = await fetch(url);
                    if (!respuesta.ok) {
                        alert("Error de Conexión");
                        return null;
                    }
                    return await respuesta.json();
                } catch (e) {
                    console.log("Error:", e);
                    return null;
                }
            };

            const MostrarDatos = async () => {
                const datos = await MyFetch("http://localhost:8000/api/products");
                if (!datos) return;

                miTabla.replaceChildren();
                let miElementoDatbla = ` 
                    <thead class="table-dark border">
                        <tr>
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col" class="text-center">Nombre</th>
                            <th scope="col" class="text-center">Precio</th>
                            <th scope="col" class="text-center">Stock</th>
                            <th scope="col" class="text-center">Eliminar</th>
                            <th scope="col" class="text-center">Actualizar</th>
                        </tr>
                    </thead>
                    <tbody>`;

                datos.forEach((e) => {
                    miElementoDatbla += `
                        <tr>
                            <th data-id="${e.id}" scope="row" class="text-center">${e.id}</th>
                            <td>${e.nombre}</td>
                            <td>${e.precio}</td>
                            <td>${e.stock}</td>
                            <td class="text-center">
                                <button class="btn btn-outline-danger btn-sm" onclick="EliminarDatos(this)">Eliminar</button>
                            </td>
                            <td class="text-center">
                                <button
                                    onclick="ModalActualizarId(this)"
                                    type="button"
                                    class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModalCenter">
                                    Actualizar
                                </button>
                            </td>
                        </tr>`;
                });

                miElementoDatbla += `</tbody>`;
                miTabla.insertAdjacentHTML("beforeend", miElementoDatbla);
            };

            MostrarDatos();

            window.ModalActualizarId = function(button) {
                const tr = button.closest("tr");
                const id = tr.children[0].dataset.id;
                idActualizar.textContent = `ID: ${id}`;
                idActualizar.dataset.id = id;
                nomActualizar.value = tr.children[1].textContent;
                precioActualizar.value = tr.children[2].textContent;
                stockActualizar.value = tr.children[3].textContent;
            };

            window.ActualizarDatos = async function() {
                const id = idActualizar.dataset.id;
                if (!id) return;

                const datosActualizados = {
                    nombre: nomActualizar.value,
                    precio: parseFloat(precioActualizar.value),
                    stock: parseInt(stockActualizar.value)
                };

                try {
                    const respuesta = await fetch(`http://localhost:8000/api/products/${id}`, {
                        method: "PUT",
                        headers: { "Content-type": "application/json" },
                        body: JSON.stringify(datosActualizados),
                    });

                    if (!respuesta.ok) {
                        alert("Error en la petición");
                        return;
                    }

                    const modalEl = document.getElementById('exampleModalCenter');
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();

                    MostrarDatos();
                } catch (e) {
                    console.log("Error:", e);
                }
            };

            window.EliminarDatos = async function(e) {
                try {
                    const id = e.closest("tr").children[0].dataset.id;
                    const respuesta = await fetch(`http://localhost:8000/api/products/${id}`, {
                        method: "DELETE",
                    });

                    if (!respuesta.ok) {
                        alert("Error en la petición");
                        return;
                    }
                    MostrarDatos();
                } catch (e) {
                    console.log("Error:", e);
                }
            };

            miFormulario.addEventListener("submit", async (e) => {
                e.preventDefault();
                try {
                    const formData = new FormData(miFormulario);
                    const datos = Object.fromEntries(formData);

                    const respuesta = await fetch("http://localhost:8000/api/products/register", {
                        method: "POST",
                        headers: { "Content-type": "application/json" },
                        body: JSON.stringify(datos),
                    });

                    if (!respuesta.ok) {
                        alert("Error en la petición");
                        return;
                    }
                    miFormulario.reset();
                    MostrarDatos();
                } catch (e) {
                    console.log("Error:", e);
                }
            });
        });
    </script>
</body>

</html>