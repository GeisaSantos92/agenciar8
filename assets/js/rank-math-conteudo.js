/**
 * Rank Math: analisa o conteúdo que a página realmente exibe
 * Os textos das Soluções, Modelos de Negócio e páginas ficam em campos próprios (CMB2), fora do editor,
 * então buscamos o HTML publicado e entregamos ao Rank Math só o miolo (sem menu, rodapé e scripts)
 */
(function () {
    if (!window.wp || !wp.hooks || !window.agenciaRankMath) return;

    let conteudo = '';

    wp.hooks.addFilter('rank_math_content', 'agencia', original => conteudo || original);

    function atualizar() {
        if (window.rankMathEditor) {
            rankMathEditor.refresh('content');
        } else {
            setTimeout(atualizar, 500);
        }
    }

    fetch(agenciaRankMath.url, { credentials: 'same-origin' })
        .then(resposta => resposta.text())
        .then(html => {
            const doc = new DOMParser().parseFromString(html, 'text/html');
            doc.querySelectorAll('#wpadminbar, header.header, footer.footer, script, style, noscript, .screen-reader-text').forEach(el => el.remove());
            conteudo = doc.body.innerHTML;
            atualizar();
        });
})();
