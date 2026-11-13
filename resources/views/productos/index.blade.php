<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Sistema de Ventas</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; }
        #sidebar {
            width: 250px; position: fixed; top: 0; left: 0; height: 100vh;
            background: #1e1e2f; color: #fff; z-index: 100;
        }
        #sidebar .sidebar-header { padding: 20px; background: #151521; font-weight: bold; font-size: 1.2rem; }
        #sidebar ul.components { padding: 20px 0; }
        #sidebar ul li a { padding: 12px 20px; display: block; color: #cfd8dc; text-decoration: none; transition: 0.2s; }
        #sidebar ul li a:hover, #sidebar ul li.active a { color: #fff; background: #2d2d44; border-left: 4px solid #0d6efd; }
        #sidebar ul li a i { margin-right: 10px; }
        #content { margin-left: 250px; width: calc(100% - 250px); min-height: 100vh; }
        .top-navbar { background: #fff; padding: 15px 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <!-- MENÚ LATERAL -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <i class="fa-solid fa-cash-register"></i> Sistema Ventas
        </div>
        <ul class="list-unstyled components">
            <li class="active">
                <a href="{{ route('productos.index') }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            </li>
            <li>
                <a href="{{ route('productos.index') }}"><i class="fa-solid fa-box"></i> Productos</a>
            </li>
        </ul>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <div id="content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <span class="fw-bold text-secondary">Panel de Administración</span>
            <span class="text-dark"><i class="fa-solid fa-user-circle"></i> Administrador</span>
        </div>

        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard - Lista de Productos</h2>
                <!-- Botón Añadir con ID para controlarlo desde JS -->
                <button type="button" class="btn btn-primary" id="btnNuevo" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fa-solid fa-plus"></i> Añadir Productos +
                </button>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table table-hover align-middle productosTable">
                        <thead class="table-dark">
                            <tr>
                                <th>N°</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Se carga por AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
              <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Gestión de Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id">

                  <div class="mb-3">
                      <label class="form-label">Producto:</label>
                      <input type="text" id="producto" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Categoría:</label>
                      <input type="text" id="categoria" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Precio:</label>
                      <input type="number" step="0.01" id="precio" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Stock:</label>
                      <input type="number" id="stock" class="form-control" required>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Botón Guardar con ID (sin onclick) -->
                <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
              </div>
        </div>
      </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @vite(['resources/js/productos.js'])
</body>
</html>