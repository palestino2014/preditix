// get values from clicked row
function start(){}
var table = document.getElementById("tableImplemento");
if (table) {
  for (var i = 0; i < table.rows.length; i++) {
    table.rows[i].onclick = function() {
      tableText(this);
    };
  }
}

function tableText(tableRow) {
  var id = tableRow.childNodes[1].innerHTML;
  var age = tableRow.childNodes[3].innerHTML;
  var obj = {'ativoId': id, 'tableId': "tableImplemento"};
  populateModal(tableRow)
}

function populateModal(obj){
  var modal = document.getElementById("myModal");
  modal.innerHTML = obj.childNodes[1].innerHTML;
}

//MODAL START
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
//MODAL END


function consultarBanco() {
  var dado = document.getElementById('inputDado').value;

  if (dado.trim() !== '') {
      // Fazer uma solicitação AJAX para o servidor PHP
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
              var resultado = JSON.parse(xhr.responseText);
              criarLista(resultado);
          }
      };

      xhr.open('GET', 'php/consulta_linha.php?dado=' + dado, true);
      xhr.send();
  } else {
      alert('Digite um dado para consultar.');
  }
}

function criarLista(resultado) {
  var modal = document.getElementById('moreInformationModal');
  var conteudoModal = document.getElementById('resultado');

  conteudoModal.innerHTML = '<p>Resultados:</p>';
  
  for (var i = 0; i < resultado.length; i++) {
      conteudoModal.innerHTML += '<p>' + resultado[i].campo1 + ' - ' + resultado[i].campo2 + '</p>';
  }

  modal.style.display = 'block';
}


document.addEventListener("DOMContentLoaded", function () {
  // Obtém todas as tabelas com a classe 'tabela'
  var tabelas = document.querySelectorAll(".tabela");

  // Adiciona um ouvinte de eventos de clique a todas as tabelas
  tabelas.forEach(function (tabela) {
    tabela.addEventListener("click", function (e) {
      // Verifica se o clique ocorreu em um botão dentro da célula
      if (e.target.classList.contains("obter-dados")) {
        // Obtém a tabela clicada
        var tabelaClicada = e.currentTarget;

        // Obtém a linha correspondente ao botão clicado
        var linha = e.target.closest("tr");

        // Obtém os valores das células da linha
        var coluna2 = linha.children[1].textContent;


        // Faça o que quiser com os valores obtidos
        console.log("Tabela clicada:", tabelaClicada);
        console.log("Valores da linha:", coluna1);
      }
    });
  });
});