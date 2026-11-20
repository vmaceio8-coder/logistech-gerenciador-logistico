function adicionarProduto() {
    const container = document.getElementById('lista-produtos');
    const primeiraLinha = container.querySelector('.item-produto');
    const novaLinha = primeiraLinha.cloneNode(true);

    novaLinha.querySelector('select').value = '';
    novaLinha.querySelector('input').value = '1';

    container.appendChild(novaLinha);
}

function removerProduto(botao) {
    const container = document.getElementById('lista-produtos');
    const linhas = container.querySelectorAll('.item-produto');
    if (linhas.length > 1) {
        botao.closest('.item-produto').remove();
    } else {
        alert('O frete precisa ter pelo menos um produto.');
    }
}