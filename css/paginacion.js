document.addEventListener("DOMContentLoaded", function() {
  var elementosPorPagina = 15;
  var filas = document.getElementById("miTabla").getElementsByTagName("tbody")[0].getElementsByTagName("tr");
  var totalPaginas = Math.ceil(filas.length / elementosPorPagina);

  var paginacion = document.getElementById("paginacion");

  function mostrarPagina(paginaSeleccionada) {
    var inicio = (paginaSeleccionada - 1) * elementosPorPagina;
    var fin = inicio + elementosPorPagina;

    for (var i = 0; i < filas.length; i++) {
      filas[i].style.display = "none";
    }

    for (var i = inicio; i < fin && i < filas.length; i++) {
      filas[i].style.display = "";
    }
  }

  function generarBotonesPagina(paginaActual) {
    paginacion.innerHTML = '';

    var rangoInicio = Math.max(1, paginaActual - 3);
    var rangoFin = Math.min(totalPaginas, rangoInicio + 5);

    // Botón "Previous"
    var botonPrev = document.createElement("button");
    botonPrev.innerText = "<---";
    botonPrev.addEventListener("click", function() {
      if (paginaActual > 1) {
        mostrarPagina(paginaActual - 1);
        generarBotonesPagina(paginaActual - 1);
      }
    });
    paginacion.appendChild(botonPrev);

    // Agregar botón "..." si hay más páginas antes del rangoInicio
    if (rangoInicio > 1) {
      var botonElipsis = document.createElement("button");
      botonElipsis.innerText = "...";
      botonElipsis.addEventListener("click", function() {
        var paginaAnterior = rangoInicio - 1;
        mostrarPagina(paginaAnterior);
        generarBotonesPagina(paginaAnterior);
      });
      paginacion.appendChild(botonElipsis);
    }

    // Botones de página
    for (var i = rangoInicio; i <= rangoFin; i++) {
      var boton = document.createElement("button");
      boton.innerText = i;
      boton.addEventListener("click", function() {
        mostrarPagina(this.innerText);
        generarBotonesPagina(this.innerText);
      });
      if (i === paginaActual) {
        boton.classList.add("active");
      }
      paginacion.appendChild(boton);
    }

    // Botón "Next"
    var botonNext = document.createElement("button");
    botonNext.innerText = "--->";
    botonNext.addEventListener("click", function() {
      if (paginaActual < totalPaginas) {
        mostrarPagina(paginaActual + 1);
        generarBotonesPagina(paginaActual + 1);
      }
    });
    paginacion.appendChild(botonNext);
  }

  mostrarPagina(1);
  generarBotonesPagina(1);
});
