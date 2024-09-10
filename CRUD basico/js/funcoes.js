// js/funcoes.js
function cadastrarUsuario(event) {
    event.preventDefault();

    var formData = new FormData(document.forms["formCadastro"]);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/crud.php", true);

    xhr.onload = function () {
        console.log("Status: ", xhr.status);
        console.log("Response: ", xhr.responseText);

        if (xhr.status == 200) {
            alert("Cadastro realizado com sucesso!");
            document.forms["formCadastro"].reset();
        } else {
            alert("Erro ao cadastrar: " + xhr.responseText);
        }
    };

    xhr.onerror = function () {
        console.error("Erro na requisição.");
    };

    xhr.send(formData);
}
