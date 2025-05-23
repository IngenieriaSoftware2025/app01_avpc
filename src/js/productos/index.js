import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormProductos = document.getElementById('FormProductos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');


const GuardarProducto = async (event) => {
    event.preventDefault(); // evita que se recargue la página
    BtnGuardar.disabled = true; // deshabilita el botón para evitar múltiples envíos

    if (!validarFormulario(FormProductos, ['producto_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de llenar todos los campos",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormProductos);
    const url = '/app01_avpc/productos/guardarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos

        console.log('Respuesta del servidor:', datos);

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });


            limpiarTodo();
            BuscarProductos();

        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.error('Error en GuardarProducto:', error);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error",
            text: "Ocurrió un error",
            showConfirmButton: true,
        });
    }
    BtnGuardar.disabled = false;
}







//Hace una petición GET al servidor para obtener todos los productos
//Si es exitosa, limpia la tabla y carga los nuevos datos
//Si hay error, muestra una alerta

const BuscarProductos = async () => {
    const url = '/app01_avpc/productos/buscarAPI';
    const config = {
        method: 'GET'
    }

    try {

        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos

        if (codigo == 1) {

            datatable.clear().draw();
            datatable.rows.add(data).draw();

        } else {

            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }


    } catch (error) {
        console.log(error)
    }
}





//tabla de productos
//se crea la tabla con el id TableProductos
//cuando se guarda un producto

const datatable = new DataTable('#TableProductos', {
    //configuracion del layout
    dom: ` 
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    order: [[3, 'asc'], [4, 'asc']],
    columns: [
        { title: 'No.', data: 'producto_id', render: (data, type, row, meta) => meta.row + 1 },
        { title: 'Producto', data: 'producto_nombre', },
        { title: 'Cantidad', data: 'producto_cantidad', },
        {
            title: 'Categoría', data: 'categoria_nombre', render: (data) => {
                let color = 'bg-secondary';
                if (data === 'Alimentos') color = 'bg-success';
                if (data === 'Limpieza') color = 'bg-info';
                if (data === 'Hogar') color = 'bg-warning';
                return `<span class="badge ${color} text-white">${data}</span>`;
            }
        }, {
            title: 'Prioridad', data: 'producto_prioridad', render: (data, type, row) => {
                if (data == "A") {
                    return "ALTA"
                } else if (data == "M") {
                    return "MEDIA"
                } else if (data == "B") {
                    return "BAJA"
                }
            }
        },
        {
            title: 'Estado',
            data: 'producto_comprado',
            width: '12%',
            render: (data, type, row) => {
                if (data == 1) {
                    return "COMPRADO"
                } else {
                    return "PENDIENTE"
                }
            }
        },
        {
            title: 'Acciones',
            data: 'producto_id',
            searchable: false,
            orderable: false,
            width: '26%',
            render: (data, type, row, meta) => {
                let botones = `
                    <div class='d-flex justify-content-center'>
                        <button class='btn btn-warning btn-sm modificar mx-1' 
                            data-id="${data}" 
                            data-nombre="${row.producto_nombre}"  
                            data-cantidad="${row.producto_cantidad}"  
                            data-categoria="${row.producto_categoria_id}"  
                            data-prioridad="${row.producto_prioridad}">
                            <i class='bi bi-pencil-square'></i>Modificar
                        </button>`;


                if (row.producto_comprado == 0) {
                    botones += `
                        <button class='btn btn-success btn-sm marcar-comprado mx-1' 
                            data-id="${data}">
                            <i class="bi bi-check"></i> Comprado
                        </button>`;
                }

                botones += `
                        <button class='btn btn-danger btn-sm eliminar mx-1' 
                            data-id="${data}">
                            <i class="bi bi-trash3"></i> Eliminar
                        </button>
                    </div>`;

                return botones;
            }
        }
    ],

});






//CARGA LAS CATEGORIAS EN EL SELECT DEL INDEX
const CargarCategorias = async () => {
    const url = '/app01_avpc/productos/categoriasAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos

        if (codigo == 1) {
            const select = document.getElementById('producto_categoria_id');
            select.innerHTML = '<option value="">Seleccione categoría</option>';

            data.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.categoria_id;
                option.textContent = categoria.categoria_nombre;
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error en CargarCategorias:', error);
    }
}







//llena los datos del formulario para modificar
//cuando se da click en el boton modificar
//se obtiene el id del producto y se llena el formulario

const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset //obtiene los datos del boton

    document.getElementById('producto_id').value = datos.id
    document.getElementById('producto_nombre').value = datos.nombre
    document.getElementById('producto_cantidad').value = datos.cantidad
    document.getElementById('producto_categoria_id').value = datos.categoria
    document.getElementById('producto_prioridad').value = datos.prioridad

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    })
}

const limpiarTodo = () => {
    FormProductos.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}





//modificar producto
//se obtiene el id del producto y se hace una peticion al servidor

const ModificarProducto = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormProductos, [''])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormProductos);
    const url = '/app01_avpc/productos/modificarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarProductos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.error('Error en ModificarProducto:', error);
    }
    BtnModificar.disabled = false;
}







//eliminar producto
//se obtiene el id del producto y se hace una peticion al servidor
//para eliminar el producto
//se muestra una alerta de confirmacion
//si se confirma la eliminacion se hace la peticion
//si se elimina el producto se muestra una alerta de exito


const EliminarProducto = async (e) => {
    const idProducto = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea eliminar este producto?",
        text: 'Esta acción no se puede deshacer',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#d33',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/app01_avpc/productos/eliminar?id=${idProducto}`;
        const config = {
            method: 'GET'
        }

        try {
            const consulta = await fetch(url, config);
            const respuesta = await consulta.json();
            const { codigo, mensaje } = respuesta;

            if (codigo == 1) {
                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Éxito",
                    text: mensaje,
                    showConfirmButton: true,
                });

                BuscarProductos();
            } else {
                await Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showConfirmButton: true,
                });
            }
        } catch (error) {
            console.error('Error en EliminarProducto:', error);
        }
    }
}





//marcar como comprado
//se obtiene el id del producto y se hace una peticion al servidor
//para marcar el producto como comprado


const MarcarComprado = async (e) => {
    const idProducto = e.currentTarget.dataset.id

    const body = new FormData();
    body.append('producto_id', idProducto);
    body.append('producto_comprado', 1);

    const url = '/app01_avpc/productos/marcarCompradoAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos

        if (codigo == 1) {
            BuscarProductos();
            BuscarProductosComprados();

        }
    } catch (error) {
        console.log(error)
    }
}







// seccion de productos comprados

const datatableComprados = new DataTable('#TableComprados', {
    language: lenguaje,
    data: [],
    columns: [
        { title: 'No.', data: 'producto_id', render: (data, type, row, meta) => meta.row + 1 },
        { title: 'Producto', data: 'producto_nombre' },
        { title: 'Cantidad', data: 'producto_cantidad' },
        { title: 'Categoría', data: 'categoria_nombre' },
        {
            title: 'Prioridad', data: 'producto_prioridad', render: (data, type, row) => {
                if (data == "A") {
                    return "ALTO"
                } else if (data == "M") {
                    return "MEDIO"
                } else if (data == "B") {
                    return "BAJO"
                }
            }
        }
    ]
});





//Obtiene las categorías del servidor
//Limpia el select de categorías
//Crea opciones dinámicamente para cada categoría
//Las agrega al select del formulario


// seccion de productos comprados
// se obtiene la lista de productos comprados

const BuscarProductosComprados = async () => {
    const url = '/app01_avpc/productos/buscarCompradosAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos

        if (codigo == 1) {
            datatableComprados.clear().draw();
            datatableComprados.rows.add(data).draw();


            document.getElementById('SeccionComprados').style.display = 'block';
        }
    } catch (error) {
        console.log(error)
    }
}


CargarCategorias();
BuscarProductos();
datatable.on('click', '.eliminar', EliminarProducto);
datatable.on('click', '.modificar', llenarFormulario);
datatable.on('click', '.marcar-comprado', MarcarComprado);
FormProductos.addEventListener('submit', GuardarProducto);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarProducto);



//Async/Await: Para manejar peticiones asíncronas
//Fetch API: Para comunicarse con el servidor
//FormData: Para enviar datos de formularios
//Event Delegation: Para manejar eventos en elementos dinámicos
//Template Literals: Para crear HTML dinámico
//Destructuring: Para extraer datos de objetos (const { codigo, mensaje } = datos)