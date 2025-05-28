document.addEventListener('DOMContentLoaded', () => {
   
    cartButton.addEventListener('click', openCart);
    closeCarrito.addEventListener('click', closeSidebar);

    cargarEventListeners();

});

const cartButton = document.querySelector('#cart');
const contCarrito = document.querySelector('.contCarrito');
const closeCarrito = document.querySelector('.close');
const carrito = document.querySelector('#contCarrito');
const listaCarrito = document.querySelector('#lista-carrito');
const productsCont = document.querySelector('#productsCont');
const vaciarCarrito = document.querySelector('#vaciarCarrito');
const spanContador = document.querySelector('.span-contador');
// Summary cart
const summaryCont = document.querySelector('.productos');
const formatterUSD = new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'USD'
  });

let productosCarrito = []

const openCart = () => {
    contCarrito.style.right = '0';
};

const closeSidebar = () => {
    contCarrito.style.right = '-40rem';
};

function cargarEventListeners(){
    productsCont.addEventListener('click', agregarProducto);
    carrito.addEventListener('click', eliminarProducto);

    productosCarrito = JSON.parse(localStorage.getItem('carrito')) || [];
    carritoHTML();

    vaciarCarrito.addEventListener('click', (e) => {
        e.preventDefault();
        productosCarrito = [];
        limpiarHTML(listaCarrito);
        agregarStorage();
        carritoHTML();
    })
}

function agregarProducto(e){
    if(e.target.classList.contains('btn-addCart')){
        e.preventDefault();
        const productSeleccionado = e.target.parentElement.parentElement.parentElement;
        leerDatosProducto(productSeleccionado);
        alertaCarrito('Agregado Correctamente');
    }
    
}

function eliminarProducto(e){
    
    if(e.target.classList.contains('btn-borrar')){
        e.preventDefault();
        const productoId = e.target.getAttribute('data-id');

        productosCarrito = productosCarrito.filter(producto => producto.id !== productoId);

        carritoHTML();
    }
}

function leerDatosProducto(producto){

    const infoProducto = {
        imagen: producto.querySelector('img').src,
        titulo: producto.querySelector('h2').textContent,
        precio: producto.querySelector('.precio').textContent,
        id: producto.querySelector('#addToCart').getAttribute('data-id'),
        cantidad: 1
    }

    const existe = productosCarrito.some(producto => producto.id === infoProducto.id);
    if(existe){
        const productos = productosCarrito.map(producto => {
            if(producto.id === infoProducto.id){
                producto.cantidad++;
                return producto;
            }else {
                return producto;
            }
        });
        productosCarrito = [...productos];
    }else {
        productosCarrito = [...productosCarrito, infoProducto];
    }

    carritoHTML();
}

function carritoHTML(){
    limpiarHTML(listaCarrito);

    productosCarrito.forEach(productoCarrito => {
        const {imagen, titulo, precio, id,  cantidad} = productoCarrito;
        
        const divArticulo = document.createElement('DIV');
        divArticulo.classList.add('articulo')

        const picture = document.createElement('IMG');
        picture.src = imagen;
        picture.alt = `Imagen de ${titulo}`;
        picture.classList.add('img-cart');

        const divInfo = document.createElement('DIV');
        divInfo.classList.add('info')

        const name = document.createElement('P');
        name.textContent = titulo;
        
        const precios = document.createElement('P');
        precios.textContent = precio;

        const cantidades = document.createElement('P');
        cantidades.textContent = `Cantidad: ${cantidad}`;

        const divBorrar = document.createElement('DIV');

        const btnBorrar = document.createElement('A');
        btnBorrar.href = '#';
        btnBorrar.textContent = 'X';
        btnBorrar.classList.add('btn-borrar');
        btnBorrar.dataset.id = id;

        divBorrar.appendChild(btnBorrar);

        divInfo.appendChild(name)
        divInfo.appendChild(precios)
        divInfo.appendChild(cantidades)

        divArticulo.appendChild(picture);
        divArticulo.appendChild(divInfo);
        divArticulo.appendChild(divBorrar)

        listaCarrito.appendChild(divArticulo);
    });
    spanContador.textContent=productosCarrito.length;

    if (document.body.id === 'resumen-carrito') {
    summaryCart();
    }

    agregarStorage();
}

function summaryCart(){
    limpiarHTML(summaryCont);

    const h2Cart = document.createElement('H2');
    summaryCont.appendChild(h2Cart)

    productosCarrito.forEach(productoCarrito => {
        const {imagen, titulo, precio, id,  cantidad} = productoCarrito;
        
        const divCard = document.createElement('DIV');
        divCard.classList.add('producto');

        const imgCard = document.createElement('img');
        imgCard.src = imagen;
        imgCard.alt = `Imagen de ${titulo}`;

        const divCardInfo = document.createElement('DIV');
        divCardInfo.classList.add('info');

        const h2Name = document.createElement('H2');
        h2Name.textContent = titulo;

        const p1 = document.createElement('P');
        p1.textContent = 'Precio Unitario: ';
        const span1 = document.createElement('SPAN');
        span1.textContent = formatterUSD.format(precio);

        const p2 = document.createElement('P');
        p2.textContent = 'Cantidad: ';
        const input1 = document.createElement('SPAN');
        input1.textContent = cantidad;
        input1.classList.add('span-cantidad');

        const p3 = document.createElement('P');
        p3.textContent = 'Total de Articulo: ';
        const span2 = document.createElement('SPAN');
        span2.textContent = formatterUSD.format(parseFloat(precio) * cantidad);

        p1.appendChild(span1);
        p2.appendChild(input1);
        p3.appendChild(span2);

        divCardInfo.appendChild(h2Name);
        divCardInfo.appendChild(p1);
        divCardInfo.appendChild(p2);
        divCardInfo.appendChild(p3);

        divCard.appendChild(imgCard);
        divCard.appendChild(divCardInfo);

        summaryCont.appendChild(divCard);
    });

    totalCarrito();
}

function totalCarrito(){
    const totalCont = document.querySelector('#total-carrito')
    const totales = productosCarrito.map(producto => {
        return {...producto, total: producto.cantidad * parseFloat(producto.precio)}});

        const sumaTotal = totales.reduce((acumulador, producto) => acumulador + producto.total, 0);

        totalCont.textContent = formatterUSD.format(sumaTotal);
}

function agregarStorage(){
    localStorage.setItem('carrito', JSON.stringify(productosCarrito));
}

function limpiarHTML(contenedor){
    while(contenedor.firstChild){
        contenedor.removeChild(contenedor.firstChild)
    }
}

function alertaCarrito(mensaje){
    Toastify({
        text: mensaje,
        duration: 1000,
        style: {
            background: "var(--morado-munfrost)",
          }
        }).showToast();
}

const boton_comprar = document.getElementById("a-pagar");
boton_comprar.addEventListener("click", confirmarCompra);

function confirmarCompra(e) {
    e.preventDefault(); 
    Swal.fire({
        title: "¿Desa continuar con la compra?",
        showDenyButton: true,
        confirmButtonText: "Confirmar",
        denyButtonText: `Cancelar`
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire("Compra hecha con exito", "", "success");
            limpiarHTML(summaryCont);
            localStorage.removeItem('carrito');
        } else if (result.isDenied) {
            Swal.fire("Piche mamon", "", "error");
        }
    });
}
