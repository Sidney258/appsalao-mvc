let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener("DOMContentLoaded", function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion();
    tabs(); //muda a seccao quando pressionam as tabs
    botonesPaginador(); //agrega ou quita los botones del paginador
    paginaAnterior()
    paginaSiguiente();
    consultarAPI(); //consulta a API no backend
    idCliente(); // adiciona o id do cliente ao objecto de cita
    nombreCliente(); // adiciona o nome do cliente ao objecto de cita
    seleccionaFecha(); // seleciona a data da reserva
    seleccionarHora(); // seleciona a hora da reserva
    mostrarResumen(); // mostrar o resuma da reserva
}

function mostrarSeccion() {
    // ocultar seccion que tenga la classe de mostrar
    const seccionAnterior = document.querySelector(".mostrar");
    if (seccionAnterior) {
        seccionAnterior.classList.remove("mostrar");
    }

    // selecionar la seccion com el paso...
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    const tabAnterior = document.querySelector(".actual");
    if (tabAnterior) {
        tabAnterior.classList.remove("actual");
    }

    // resaltar el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add("actual");

}

function tabs() {
    const botones = document.querySelectorAll(".tabs button");

    botones.forEach(boton => {
        boton.addEventListener("click", function (e) {
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();

            if (paso === 3) {
                mostrarResumen();
            }
        });
    });
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector("#anterior");
    const paginaSiguiente = document.querySelector("#siguiente");

    if (paso === 1) {
        paginaAnterior.classList.add("ocultar");
        paginaSiguiente.classList.remove("ocultar");
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector("#anterior");

    paginaAnterior.addEventListener("click", function () {
        if (paso <= pasoInicial) return;
        paso = paso - 1;
        botonesPaginador();
    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector("#siguiente");

    paginaSiguiente.addEventListener("click", function () {
        if (paso >= pasoFinal) return;
        paso = paso + 1;
        botonesPaginador();
    });
}

async function consultarAPI() {

    try {
        const url = '/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicio(servicios);

    } catch (error) {
        console.log(error);
    }

}

function mostrarServicio(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio)
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);

    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // verificar se um servico ja foi selecionado
    if (servicios.some(agregado => agregado.id === id)) {
        // eliminar
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    } else {
        //agregar
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }

}

function idCliente() {
    id = document.querySelector('#id').value;

    cita.id = id;
}

function nombreCliente() {
    nombre = document.querySelector('#nombre').value;

    cita.nombre = nombre;

}

function seleccionaFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {
        const dia = new Date(e.target.value).getUTCDay();

        if ([6, 0].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('Fins de semana nao sao permitidos', 'error', '.formulario');
        } else {
            cita.fecha = e.target.value;
        }
    });
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {

    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    }

    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) {
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {
        const horaCita = e.target.value;
        const hora = horaCita.split(':')[0];
        if (hora < 10 || hora > 18) {
            e.target.value = '';
            mostrarAlerta('Hora invalida', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;
        }
    })
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltam dados de Servicos, Data e Hora', 'error', '.contenido-resumen', false);

        return;
    }

    // formatear el div de resumen
    const { nombre, fecha, hora, servicios } = cita;


    // Heading de servicios en el resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumo dos Servicos';
    resumen.appendChild(headingServicios);

    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Preco:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumo da Reserva';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nome:</span> ${nombre}`;

    // formtar la fecha em portugues
    const fechaObj = new Date(fecha);

    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate();
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
    const fechaFormateada = fechaUTC.toLocaleDateString('pt-PT', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Data:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`;

    // Boton para crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);
}

async function reservarCita() {

    const { nombre, fecha, hora, servicios, id } = cita;

    const idServicios = servicios.map(servicio => servicio.id)

    const datos = new FormData();
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    try {

        const url = '/api/citas';

        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();

        // * verificar si la cita se guardo correctamente e anadir sweet alert
        if (resultado.resultado) {
            Swal.fire({
                icon: 'success',
                title: 'Reserva Criada Correctamente',
                text: 'A tua reserva foi criada correctamente',
                button: 'OK'
            }).then(() => {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            })
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Erro ao Criar a Reserva',
            text: 'Ocorreu um erro ao criar a reserva. Por favor, tenta novamente.'
        });
    }

}