function saudacao() {
  const agora = new Date();
  const horas = agora.getHours();
  let textoSaudacao;

  if (horas >= 0 && horas < 12) {
    textoSaudacao = "Bom dia,";
  } else if (horas >= 12 && horas < 18) {
    textoSaudacao = "Boa tarde,";
  } else {
    textoSaudacao = "Boa noite,";
  }

  const saudacaoEl = document.getElementById("saudacao");
  if (saudacaoEl) {
    saudacaoEl.innerText = textoSaudacao;
  }
}

document.addEventListener("DOMContentLoaded", () => {
  saudacao();

  const token = localStorage.getItem('token');

  if (!token || token === "undefined") {
    alert("Usuário não autenticado.");
    return;
  }

  fetch('http://127.0.0.1:8000/api/compra-atual', {
    method: 'GET',
    headers: {
      'Authorization': 'Bearer ' + token,
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (data && data.id_compra) {
      console.log("Compra atual:", data);
      alert("ID da última compra: " + data.id_compra);

      const idCompraInput = document.querySelector("input[name='id_compra']");
      if (idCompraInput) {
        idCompraInput.value = data.id_compra;
      }
    } else {
      alert("Compra atual não encontrada.");
    }
  })
  .catch(err => {
    console.error(err);
    alert("Erro ao buscar a compra atual.");
  });

  const starContainers = document.querySelectorAll(".star-rating");

  starContainers.forEach(container => {
    const stars = container.querySelectorAll(".star");
    stars.forEach(star => {
      star.addEventListener("click", () => {
        const value = Number(star.getAttribute("data-value"));

        stars.forEach(s => s.classList.remove("active"));

        for (let i = 0; i < value; i++) {
          stars[i].classList.add("active");
        }

        const inputHidden = container.querySelector("input[type='hidden']");
        if (inputHidden) {
          inputHidden.value = value;
        }
      });
    });
  });

  const form = document.querySelector("form");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const email = form.email.value.trim();
    const id_compra = form.id_compra.value.trim();

    if (!email || !id_compra) {
      alert("Preencha email e ID da compra.");
      return;
    }

    const perguntasMapeadas = [
      { id_pergunta: 1, tipo: "estrela", campo: "compra" },
      { id_pergunta: 2, tipo: "estrela", campo: "navegacao" },
      { id_pergunta: 3, tipo: "estrela", campo: "pagamento" },
      { id_pergunta: 4, tipo: "estrela", campo: "recomendacao" },
      { id_pergunta: 5, tipo: "estrela", campo: "prazo" },
      { id_pergunta: 6, tipo: "estrela", campo: "condicao" },
      { id_pergunta: 7, tipo: "estrela", campo: "frete" },
      { id_pergunta: 8, tipo: "sim_nao", campo: "suporte" },
      { id_pergunta: 9, tipo: "estrela", campo: "avaliacao_suporte" },
      { id_pergunta: 10, tipo: "sim_nao", campo: "contato" }
    ];

    const respostas = [];

    perguntasMapeadas.forEach(pergunta => {
      let valor;

      if (pergunta.tipo === "sim_nao") {
        valor = form[pergunta.campo].value;
      } else if (pergunta.tipo === "estrela") {
        const container = document.querySelector(`.star-rating[data-name="${pergunta.campo}"]`);
        const input = container?.querySelector("input[type='hidden']");
        valor = input ? input.value : null;
      }

      if (valor !== null && valor !== "") {
        respostas.push({
          id_pergunta: pergunta.id_pergunta,
          avaliacao: valor
        });
      }
    });

    if (respostas.length === 0) {
      alert("Nenhuma resposta preenchida.");
      return;
    }

    const comentarioSuporte = form['comentario-suporte']?.value.trim() || null;

    const dados = {
      email,
      id_compra: Number(id_compra),
      respostas,
      comentario_suporte: comentarioSuporte
    };

    try {
      const response = await fetch("http://127.0.0.1:8000/api/feedback", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json"
        },
        body: JSON.stringify(dados)
      });

      if (!response.ok) {
        const errorData = await response.json().catch(() => null);
        const msg = errorData?.error || errorData?.message || `Erro ${response.status}`;
        throw new Error(msg);
      }

      const json = await response.json();

      alert(json.message || "Feedback enviado com sucesso!");
      form.reset();

      starContainers.forEach(container => {
        container.querySelectorAll(".star").forEach(star => star.classList.remove("active"));
        const inputHidden = container.querySelector("input[type='hidden']");
        if (inputHidden) inputHidden.value = 0;
      });

    } catch (error) {
      console.error("Erro ao enviar feedback:", error);
      alert("Erro ao enviar feedback: " + error.message);
    }
  });
});

document.querySelectorAll('.star-rating').forEach(starRating => {
  const estrelas = starRating.querySelectorAll('.star');
  const comentario = starRating.nextElementSibling; 
  const hiddenInput = starRating.querySelector('input[type="hidden"]');

  estrelas.forEach(estrela => {
    estrela.addEventListener('click', () => {
      
      hiddenInput.value = estrela.dataset.value;

      
      estrelas.forEach(s => {
        if (s.dataset.value <= estrela.dataset.value) {
          s.classList.add('active');
        } else {
          s.classList.remove('active');
        }
      });

      
      if (comentario) comentario.style.display = 'block';
    });
  });
});

document.getElementById('botao-limpar').addEventListener('click', function() {
    if (confirm('Tem certeza que deseja limpar todo o formulário?')) {
        const form = document.querySelector('form');
        form.reset();

        // Limpar as estrelas visualmente e os valores hidden
        const starRatings = document.querySelectorAll('.star-rating');
        starRatings.forEach(starRating => {
            const stars = starRating.querySelectorAll('.star');
            stars.forEach(star => star.classList.remove('active'));
            const hiddenInput = starRating.querySelector('input[type="hidden"]');
            if (hiddenInput) hiddenInput.value = '0';
        });

        // Opcional: limpar os comentários que ficam visíveis após avaliação
        const comentarios = document.querySelectorAll('.comentario-adicional');
        comentarios.forEach(textarea => {
            textarea.style.display = 'none';
            textarea.value = '';
        });
    }
});

