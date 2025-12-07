const inputArch = document.getElementById('archivo');
const infoArch = document.getElementById('info-archivo');
const areaVista = document.getElementById('area-vista');
const visor = document.getElementById('visor');
const nombreArch = document.getElementById('nombre-archivo');
const btnCerrar = document.getElementById('btn-cerrar');

inputArch.addEventListener('change', manejarArchivo);
btnCerrar.addEventListener('click', cerrarVisor);

function manejarArchivo(e) {
    const arch = e.target.files[0];
    
    if (!arch) {
        return;
    }

    const ext = arch.name.split('.').pop().toLowerCase();
    const tamano = (arch.size / 1024 / 1024).toFixed(2);
    
    infoArch.innerHTML = `Archivo: ${arch.name} (${tamano} MB)`;
    nombreArch.textContent = arch.name;
    
    visor.innerHTML = '<div class="cargando">Cargando archivo...</div>';
    areaVista.classList.remove('oculto');

    switch(ext) {
        case 'pdf':
            cargarPDF(arch);
            break;
        case 'doc':
        case 'docx':
            cargarWord(arch);
            break;
        case 'xls':
        case 'xlsx':
            cargarExcel(arch);
            break;
        default:
            mostrarError('Formato no soportado');
    }
}

function cargarPDF(arch) {
    const url = URL.createObjectURL(arch);
    visor.innerHTML = `<iframe src="${url}"></iframe>`;
}

function cargarWord(arch) {
    const lector = new FileReader();
    
    lector.onload = function(e) {
        const datos = e.target.result;
        
        if (typeof mammoth === 'undefined') {
            mostrarError('Error: Librería Mammoth no cargada');
            return;
        }
        
        mammoth.convertToHtml({arrayBuffer: datos})
            .then(function(resultado) {
                if (resultado.value) {
                    visor.innerHTML = '<div class="contenido-word">' + resultado.value + '</div>';
                } else {
                    mostrarError('El documento está vacío o no pudo ser leído');
                }
                
                if (resultado.messages && resultado.messages.length > 0) {
                    console.log('Advertencias:', resultado.messages);
                }
            })
            .catch(function(error) {
                mostrarError('Error al cargar el documento Word: ' + error.message);
                console.error('Error completo:', error);
            });
    };
    
    lector.onerror = function() {
        mostrarError('Error al leer el archivo');
    };
    
    lector.readAsArrayBuffer(arch);
}

function cargarExcel(arch) {
    const lector = new FileReader();
    
    lector.onload = function(e) {
        const datos = new Uint8Array(e.target.result);
        const libro = XLSX.read(datos, {type: 'array'});
        
        let html = '';
        
        libro.SheetNames.forEach(function(nombreHoja) {
            const hoja = libro.Sheets[nombreHoja];
            const tablaHtml = XLSX.utils.sheet_to_html(hoja);
            
            html += `
                <div class="hoja-excel">
                    <h3>Hoja: ${nombreHoja}</h3>
                    ${tablaHtml}
                </div>
            `;
        });
        
        visor.innerHTML = html;
    };
    
    lector.readAsArrayBuffer(arch);
}

function cerrarVisor() {
    areaVista.classList.add('oculto');
    visor.innerHTML = '';
    inputArch.value = '';
    infoArch.innerHTML = '';
}

function mostrarError(msg) {
    visor.innerHTML = `<div class="error">${msg}</div>`;
}