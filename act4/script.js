cargarContenidoAjax();
function cargarContenidoAjax(){
    var xhr= new XMLHttpRequest();
    let num = 0;
    xhr.open("GET","servidor.php?num="+num,true);
    xhr.onreadystatechange = function(){
        console.log(xhr.readyState);
        if(xhr.readyState==4 && xhr.status==200){
            var json = JSON.parse(xhr.responseText);
            console.log(json);
            var contenido = document.getElementById("idP");
            for(i=0;i<json.length;i++){
                var option = document.createElement("option");
                option.text=json[i].nombre;
                option.value=json[i].id;
                contenido.add(option);
                contenido.setAttribute("onchange","cargarContenidoAjax1();");
            }
            contenido.disabled=false;
        }
    }
    xhr.send();
}

function cargarContenidoAjax1(){
    var xhr= new XMLHttpRequest();
    let num = 1;
    let id = document.getElementById("idP").value;
    if(id!=0){
        xhr.open("GET","servidor.php?id="+id+"&& num="+num,true);
        xhr.onreadystatechange = function(){
            console.log(xhr.readyState);
            if(xhr.readyState==4 && xhr.status==200){
                var json = JSON.parse(xhr.responseText);
                console.log(json);
                var contenido = document.getElementById('idE');
                contenido.innerHTML = "";
                var option = document.createElement("option");
                option.text="Seleccione...";
                option.value=0;
                contenido.add(option);
                for(i=0;i<json.length;i++){
                    var option = document.createElement("option");
                    option.text=json[i].nombre;
                    option.value=json[i].id;
                    contenido.add(option);
                    contenido.setAttribute("onchange","cargarContenidoAjax2();");
                }
                contenido.disabled=false;
                document.getElementById("idM").innerHTML="";
                document.getElementById("idM").disabled = true;
            }
        }
        xhr.send();
    }else{
        document.getElementById("idE").innerHTML="";
        document.getElementById("idE").disabled = true;
        document.getElementById("idM").innerHTML="";
        document.getElementById("idM").disabled = true;
    }
}

function cargarContenidoAjax2(){
    var xhr= new XMLHttpRequest();
    let num = 2;
    let id = document.getElementById("idE").value;
    if(id!=0){
        xhr.open("GET","servidor.php?id="+id+"&& num="+num,true);
        xhr.onreadystatechange = function(){
            console.log(xhr.readyState);
            if(xhr.readyState==4 && xhr.status==200){
                var json = JSON.parse(xhr.responseText);
                console.log(json);
                var contenido = document.getElementById('idM');
                contenido.innerHTML = "";
                var option = document.createElement("option");
                option.text="Seleccione...";
                option.value=0;
                contenido.add(option);
                for(i=0;i<json.length;i++){
                    var option = document.createElement("option");
                    option.text=json[i].nombre;
                    option.value=json[i].id;
                    contenido.add(option);
                }
                contenido.disabled=false;
            }
        }
        xhr.send();
    }else{
        document.getElementById("idM").innerHTML="";
        document.getElementById("idM").disabled = true;
    }
}