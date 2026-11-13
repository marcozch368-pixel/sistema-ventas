import './bootstrap';

$(document).ready(function() {
    cargarProductos();

    // Limpiar formulario al hacer clic en "Añadir Productos +"
    $('#btnNuevo').on('click', function() {
        limpiarForm();
    });

    // Guardar o actualizar producto mediante AJAX al hacer clic en el botón Guardar
    $('#btnGuardar').on('click', function() {
        let id = $('#id').val();
        let producto = $('#producto').val();
        let categoria = $('#categoria').val();
        let precio = $('#precio').val();
        let stock = $('#stock').val();

        if (!producto || !categoria || !precio || !stock) {
            Swal.fire('Atención', 'Por favor llena todos los campos.', 'warning');
            return;
        }

        let datos = {
            producto: producto,
            categoria: categoria,
            precio: precio,
            stock: stock,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        let url = (id && id.trim() !== '') ? `/productos/actualizar/${id}` : '/productos';
        let method = (id && id.trim() !== '') ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: datos,
            success: function(res) {
                $('#staticBackdrop').modal('hide');
                limpiarForm();
                cargarProductos();
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: res.mensaje || 'Operación realizada correctamente',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function(err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ocurrió un error al procesar los datos.'
                });
            }
        });
    });

    // Limpiar el formulario automáticamente al cerrar o cancelar el modal
    $('#staticBackdrop').on('hidden.bs.modal', function() {
        limpiarForm();
    });
});

// Función para vaciar los inputs y el ID oculto
function limpiarForm() {
    $('#id').val('');
    $('#producto').val('');
    $('#categoria').val('');
    $('#precio').val('');
    $('#stock').val('');
}

// Cargar productos en la tabla dinámicamente
function cargarProductos() {
    $.ajax({
        url: '/productos/obtenerProductos',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res){
            let productos = res.productos;
            let html = '';
            productos.forEach((item, index) => {
                let idProd = item.idproducto || item.id;
                let nombreProd = item.producto || '';
                let catProd = item.categoria || item.categoría || '';
                let precioProd = item.precio || 0;
                let stockProd = item.stock || 0;

                html += `<tr>
                    <td>${index + 1}</td>
                    <td class="fw-bold">${nombreProd}</td>
                    <td><span class="badge bg-secondary">${catProd}</span></td>
                    <td>$${Number(precioProd).toFixed(2)}</td>
                    <td>${stockProd}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm editar"
                            data-id="${idProd}"
                            data-producto="${nombreProd}"
                            data-categoria="${catProd}"
                            data-precio="${precioProd}"
                            data-stock="${stockProd}"
                            data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            <i class="fa-solid fa-pen"></i> Editar
                        </button>
                        <button type="button" class="btn btn-danger btn-sm eliminar" data-id="${idProd}">
                            <i class="fa-solid fa-trash"></i> Eliminar
                        </button>
                    </td>
                </tr>`;
            });
            $('.productosTable tbody').html(html);
        }
    });
}

// Cargar datos en el modal al hacer clic en Editar
$(document).on('click', '.editar', function() {
    $('#id').val($(this).data('id'));
    $('#producto').val($(this).data('producto'));
    $('#categoria').val($(this).data('categoria'));
    $('#precio').val($(this).data('precio'));
    $('#stock').val($(this).data('stock'));
});

// Eliminar producto con confirmación de SweetAlert2
$(document).on('click', '.eliminar', function() {
    let id = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, ¡elimínalo!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/productos/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    cargarProductos();
                    Swal.fire('¡Eliminado!', res.mensaje || 'El producto ha sido eliminado.', 'success');
                },
                error: function(err) {
                    console.error(err);
                    Swal.fire('Error', 'No se pudo eliminar el producto.', 'error');
                }
            });
        }
    });
});