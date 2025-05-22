<div class="container py-5">
    <div class="row mb-5 justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body" style="background: linear-gradient(135deg, #f8fafc 40%, #e8f5e8 100%);">
                    <div class="mb-4 text-center">
                        <h5 class="fw-bold text-secondary mb-2">Lista de Compras Inteligente</h5>
                        <h3 class="fw-bold mb-0" style="color: #2d5a2d;">GESTIÓN DE PRODUCTOS</h3>
                    </div>
                    
         
                    <form id="FormProductos" class="p-4 bg-white rounded-4 shadow-sm border">
                        <input type="hidden" id="producto_id" name="producto_id">
                        
                        <div class="row g-4 mb-3">
                            <div class="col-md-6">
                                <label for="producto_nombre" class="form-label fw-semibold">Nombre del Producto</label>
                                <input type="text" class="form-control form-control-lg rounded-3" id="producto_nombre" name="producto_nombre" placeholder="Ej. Papel higiénico" required>
                            </div>
                            <div class="col-md-6">
                                <label for="producto_cantidad" class="form-label fw-semibold">Cantidad</label>
                                <input type="number" class="form-control form-control-lg rounded-3" id="producto_cantidad" name="producto_cantidad" placeholder="Ej. 3" min="1" required>
                            </div>
                        </div>
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="producto_categoria_id" class="form-label fw-semibold">Categoría</label>
                                <select name="producto_categoria_id" class="form-select form-select-lg rounded-3" id="producto_categoria_id" required>
                                    <option value="">-- Seleccione la categoría --</option>
                                    <?php foreach($categorias as $categoria): ?>
                                        <option value="<?= $categoria['categoria_id'] ?>"><?= $categoria['categoria_nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="producto_prioridad_id" class="form-label fw-semibold">Prioridad</label>
                                <select name="producto_prioridad_id" class="form-select form-select-lg rounded-3" id="producto_prioridad_id" required>
                                    <option value="">-- Seleccione la prioridad --</option>
                                    <?php foreach($prioridades as $prioridad): ?>
                                        <option value="<?= $prioridad['prioridad_id'] ?>"><?= $prioridad['prioridad_nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <button class="btn btn-lg px-4 shadow-sm rounded-pill" type="submit" id="BtnGuardar" style="background-color: #2d5a2d; color: white;">
                                <i class="bi bi-plus-circle me-2"></i>Agregar a Lista
                            </button>
                            <button class="btn btn-secondary btn-lg px-4 shadow-sm rounded-pill" type="reset" id="BtnLimpiar">
                                <i class="bi bi-eraser me-2"></i>Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center mt-5">
        <div class="col-lg-11">
            <div class="card shadow-lg border-0 rounded-3" style="border-left: 5px solid #2d5a2d !important;">
                <div class="card-body">
                    <h3 class="text-center mb-4"> Mi Lista de Compras</h3>
                    <div id="listaProductos">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="<?= asset('build/js/productos/index.js') ?>"></script>