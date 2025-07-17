<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Inventarios - API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .api-response {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .endpoint-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: box-shadow 0.15s ease-in-out;
        }
        .endpoint-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .method-badge {
            font-size: 0.75rem;
            font-weight: 600;
        }
        .method-get { background-color: #28a745; }
        .method-post { background-color: #007bff; }
        .method-put { background-color: #ffc107; color: #212529; }
        .method-delete { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 bg-dark text-white p-4" style="min-height: 100vh;">
                <h4><i class="fas fa-boxes"></i> SisgesIn API</h4>
                <hr>
                
                <div class="nav flex-column nav-pills">
                    <a class="nav-link text-white" href="#categories">
                        <i class="fas fa-tags"></i> Categorías
                    </a>
                    <a class="nav-link text-white" href="#products">
                        <i class="fas fa-box"></i> Productos
                    </a>
                    <a class="nav-link text-white" href="#inventory">
                        <i class="fas fa-warehouse"></i> Inventario
                    </a>
                </div>
                
                <hr>
                <div class="mt-4">
                    <h6>Base URL</h6>
                    <code id="baseUrl">http://127.0.0.1:8000/api</code>
                </div>
            </div>
            
            <div class="col-md-9 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>API Documentation & Testing</h2>
                    <button class="btn btn-outline-primary" onclick="testConnection()">
                        <i class="fas fa-plug"></i> Test Connection
                    </button>
                </div>
                
                <div id="connectionStatus" class="alert" style="display: none;"></div>
                
                <!-- Categories Section -->
                <section id="categories" class="mb-5">
                    <h3><i class="fas fa-tags text-primary"></i> Categorías</h3>
                    
                    <div class="endpoint-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge method-badge method-get">GET</span>
                                <strong>/api/categories</strong>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" onclick="testEndpoint('/api/categories', 'GET')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Obtener todas las categorías</p>
                            <small class="text-muted">
                                Parámetros opcionales: search, is_active, parent_only, parent_id, sort_by, sort_order, per_page, all
                            </small>
                        </div>
                    </div>
                    
                    <div class="endpoint-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge method-badge method-get">GET</span>
                                <strong>/api/categories/tree</strong>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" onclick="testEndpoint('/api/categories/tree', 'GET')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Obtener árbol de categorías jerárquico</p>
                        </div>
                    </div>
                    
                    <div class="endpoint-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge method-badge method-post">POST</span>
                                <strong>/api/categories</strong>
                            </div>
                            <button class="btn btn-sm btn-outline-primary" onclick="createCategory()">
                                <i class="fas fa-play"></i> Test Create
                            </button>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Crear nueva categoría</p>
                            <small class="text-muted">
                                Campos: name*, description, image, parent_id, is_active
                            </small>
                        </div>
                    </div>
                </section>
                
                <!-- Products Section -->
                <section id="products" class="mb-5">
                    <h3><i class="fas fa-box text-success"></i> Productos</h3>
                    
                    <div class="endpoint-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge method-badge method-get">GET</span>
                                <strong>/api/products</strong>
                            </div>
                            <button class="btn btn-sm btn-outline-success" onclick="testEndpoint('/api/products', 'GET')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Obtener todos los productos</p>
                            <small class="text-muted">
                                Parámetros: search, category_id, brand_id, is_active, sort_by, sort_order, per_page
                            </small>
                        </div>
                    </div>
                    
                    <div class="endpoint-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge method-badge method-get">GET</span>
                                <strong>/api/products/low-stock</strong>
                            </div>
                            <button class="btn btn-sm btn-outline-success" onclick="testEndpoint('/api/products/low-stock', 'GET')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Productos con stock bajo</p>
                        </div>
                    </div>
                </section>
                
                <!-- Inventory Section -->
                <section id="inventory" class="mb-5">
                    <h3><i class="fas fa-warehouse text-warning"></i> Inventario</h3>
                    
                    <div class="endpoint-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge method-badge method-get">GET</span>
                                <strong>/api/inventory/movements</strong>
                            </div>
                            <button class="btn btn-sm btn-outline-warning" onclick="testEndpoint('/api/inventory/movements', 'GET')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Historial de movimientos de inventario</p>
                            <small class="text-muted">
                                Parámetros: product_id, warehouse_id, movement_type, date_from, date_to
                            </small>
                        </div>
                    </div>
                    
                    <div class="endpoint-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge method-badge method-get">GET</span>
                                <strong>/api/inventory/current-stock</strong>
                            </div>
                            <button class="btn btn-sm btn-outline-warning" onclick="testEndpoint('/api/inventory/current-stock', 'GET')">
                                <i class="fas fa-play"></i> Test
                            </button>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Stock actual por producto y almacén</p>
                            <small class="text-muted">
                                Parámetros: product_id, warehouse_id
                            </small>
                        </div>
                    </div>
                </section>
                
                <!-- Response Area -->
                <div id="responseArea" style="display: none;">
                    <h4>Response</h4>
                    <div class="api-response">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span id="responseStatus"></span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="clearResponse()">
                                <i class="fas fa-times"></i> Clear
                            </button>
                        </div>
                        <pre id="responseData" style="max-height: 400px; overflow-y: auto;"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const baseUrl = 'http://127.0.0.1:8000/api';
        
        async function testConnection() {
            try {
                const response = await fetch(baseUrl + '/categories');
                const status = document.getElementById('connectionStatus');
                
                if (response.ok) {
                    status.className = 'alert alert-success';
                    status.innerHTML = '<i class="fas fa-check-circle"></i> Connection successful!';
                } else {
                    status.className = 'alert alert-warning';
                    status.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Server responded with status: ' + response.status;
                }
                status.style.display = 'block';
                
                setTimeout(() => {
                    status.style.display = 'none';
                }, 3000);
                
            } catch (error) {
                const status = document.getElementById('connectionStatus');
                status.className = 'alert alert-danger';
                status.innerHTML = '<i class="fas fa-times-circle"></i> Connection failed: ' + error.message;
                status.style.display = 'block';
            }
        }
        
        async function testEndpoint(endpoint, method = 'GET', data = null) {
            try {
                const options = {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                };
                
                if (data && method !== 'GET') {
                    options.body = JSON.stringify(data);
                }
                
                const response = await fetch(baseUrl + endpoint, options);
                const responseData = await response.json();
                
                showResponse(response.status, responseData, endpoint, method);
                
            } catch (error) {
                showResponse('ERROR', {error: error.message}, endpoint, method);
            }
        }
        
        function showResponse(status, data, endpoint, method) {
            const responseArea = document.getElementById('responseArea');
            const responseStatus = document.getElementById('responseStatus');
            const responseData = document.getElementById('responseData');
            
            responseStatus.innerHTML = `<strong>${method}</strong> ${endpoint} - Status: <span class="badge ${status >= 200 && status < 300 ? 'bg-success' : 'bg-danger'}">${status}</span>`;
            responseData.textContent = JSON.stringify(data, null, 2);
            
            responseArea.style.display = 'block';
            responseArea.scrollIntoView({ behavior: 'smooth' });
        }
        
        function clearResponse() {
            document.getElementById('responseArea').style.display = 'none';
        }
        
        async function createCategory() {
            const sampleCategory = {
                name: 'Test Category ' + Date.now(),
                description: 'Categoría de prueba creada desde la API',
                is_active: true
            };
            
            await testEndpoint('/categories', 'POST', sampleCategory);
        }
        
        // Test connection on page load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(testConnection, 1000);
        });
    </script>
</body>
</html>
