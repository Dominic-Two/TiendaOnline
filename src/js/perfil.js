document.addEventListener('DOMContentLoaded', () => {
    tomarDatos();
});

const nombre = document.querySelector('.input-nombre');
const apellido = document.querySelector('.input-apellido');
const correo = document.querySelector('.input-correo');
const btn_guardar = document.querySelector('.input-guardar'); 

nombre.addEventListener('keyup', tomarDatos);
apellido.addEventListener('keyup', tomarDatos);
correo.addEventListener('keyup', tomarDatos);

function tomarDatos() {
    if (nombre.value.trim() || apellido.value.trim() || correo.value.trim()) {
        btn_guardar.classList.add('boton-habilitado');
        btn_guardar.classList.remove('boton-deshabilitado');
        btn_guardar.disabled = false;
    } else {
        btn_guardar.classList.remove('boton-habilitado');
        btn_guardar.classList.add('boton-deshabilitado');
        btn_guardar.disabled = true;
    }
}

