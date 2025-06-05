document.addEventListener("DOMContentLoaded", function () {
  // Efeito de digitação
  const text = "O seu feedback<br> é muito importante";
  const typedText = document.getElementById("typed-text");
  let index = 0;

  function typeEffect() {
    if (index < text.length) {
      if (text.slice(index, index + 4) === "<br>") {
        typedText.innerHTML += "<br>";
        index += 4;
      } else {
        typedText.innerHTML += text.charAt(index);
        index++;
      }
      setTimeout(typeEffect, 70);
    }
  }

  if (typedText) typeEffect();

  const panel = document.getElementById("panel");
  const initialContent = document.getElementById("initialContent");
  const loginForm = document.getElementById("loginForm");

  const logoArea = document.querySelector('.logo-panel-area');
  const frase = document.querySelector('.frase-content');
  const descricao = document.querySelector('.descricao-content');
  const links = document.querySelector('.links-adicionais');
  const startBtn = document.getElementById('startBtn');

  // Exibe o formulário de login com transição
  window.abrirLogin = function () {
    panel.classList.add("expandido");

    if (logoArea) logoArea.style.display = 'none';
    if (frase) frase.style.display = 'none';
    if (descricao) descricao.style.display = 'none';
    if (links) links.style.display = 'none';
    if (startBtn) startBtn.style.display = 'none';
    if (initialContent) initialContent.style.display = "none";

    setTimeout(() => {
      if (loginForm) {
        loginForm.style.display = "flex";
        loginForm.style.animation = "fadeIn 0.5s ease forwards";
      }
    }, 800); // tempo igual à transição de .expandido
  };

  // Formulário de login
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const nomeInput = document.getElementById('nome');
      const emailInput = document.getElementById('email');

      if (!nomeInput || !emailInput) return alert("Campos inválidos");

      const nome = nomeInput.value;
      const email = emailInput.value;

      fetch('http://127.0.0.1:8000/api/login', {
      method: 'POST',
      headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({ nome, email })
})
        .then(response => {
          if (!response.ok) throw new Error('Usuário não encontrado');
          return response.json();
        })
        .then(data => {
  alert('Login realizado com sucesso: ' + data.usuario.nome);

  // Armazena o token no localStorage para usar depois
  localStorage.setItem('token', data.token);

  // Redireciona para o formulário
  window.location.href = '/tela-formulario/html/index.html';
})

        .catch(err => {
          alert('Erro: ' + err.message);
        });
    });
  }
});
