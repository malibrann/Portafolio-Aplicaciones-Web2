$(".chat-btn").on("click", function(){
    let id = $(this).data("id");
    let tipo = $(this).data("tipo");
    let nombre = $(this).text();

    $("#para").val(id);
    $("#tipo").val(tipo);
    $("#titulo-chat").text(nombre);
    $("#chat").html("Cargando...");
    
    loadMessages();
});

$("#send").on("click", function () {
    let msg  = $("#msg").val().trim();
    let para = $("#para").val();
    let tipo = $("#tipo").val();

    if (!msg) return;

    $.post("send.php", { 
        accion: "enviar", 
        msg: msg, 
        para: para, 
        tipo: tipo 
    }, function () {
        $("#msg").val("");
        loadMessages();
    });
});

function loadMessages() {
    let para = $("#para").val();
    let tipo = $("#tipo").val();

    $("#chat").load("send.php", {
        accion: "leer",
        para: para,
        tipo: tipo
    }, function(){
        $("#chat").scrollTop($("#chat")[0].scrollHeight);
    });
}
setInterval(loadMessages, 1000);