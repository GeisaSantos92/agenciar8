document.addEventListener("DOMContentLoaded", () => {

    const menuButton = document.querySelector(".mobile-toggle");
    const nav = document.querySelector(".nav");
    const submenuButtons = document.querySelectorAll(".has-submenu > button");

    // Abrir/fechar menu
    menuButton?.addEventListener("click", () => {

        nav.classList.toggle("active");

        const opened = nav.classList.contains("active");

        menuButton.setAttribute("aria-expanded", opened);

        document.body.style.overflow = opened ? "hidden" : "";

    });

    // Submenus (somente mobile)
    submenuButtons.forEach(button => {

        button.addEventListener("click", e => {

            if (window.innerWidth > 992) return;

            e.preventDefault();

            const item = button.parentElement;
            const opened = item.classList.contains("open");

            // Fecha os outros
            document.querySelectorAll(".has-submenu.open").forEach(el => {

                if (el !== item) {

                    el.classList.remove("open");
                    el.querySelector("button").setAttribute("aria-expanded", "false");

                }

            });

            item.classList.toggle("open");

            button.setAttribute(
                "aria-expanded",
                !opened
            );

        });

    });

    // Fecha menu ao clicar em qualquer link
    nav.querySelectorAll("a").forEach(link => {

        link.addEventListener("click", () => {

            if (window.innerWidth > 992) return;

            nav.classList.remove("active");

            document.body.style.overflow = "";

            document.querySelectorAll(".has-submenu.open").forEach(el => {
                el.classList.remove("open");
            });

        });

    });

    // Fecha clicando fora
    document.addEventListener("click", e => {

        if (window.innerWidth > 992) return;

        if (
            nav.classList.contains("active") &&
            !nav.contains(e.target) &&
            !menuButton.contains(e.target)
        ) {

            nav.classList.remove("active");

            document.body.style.overflow = "";

            document.querySelectorAll(".has-submenu.open").forEach(el => {
                el.classList.remove("open");
            });

        }

    });

    // Voltou para desktop
    window.addEventListener("resize", () => {

        if (window.innerWidth > 992) {

            nav.classList.remove("active");

            document.body.style.overflow = "";

            document.querySelectorAll(".has-submenu.open").forEach(el => {
                el.classList.remove("open");
            });

        }

    });

});

/**carrossel performance */
const slider = document.querySelector(".performance__slider");
const track = document.querySelector(".performance__track");

let isDown = false;
let startX = 0;
let current = 0;
let previous = 0;
let min = 0;

// Mede o limite uma vez (ao arrastar ou redimensionar), e não a cada pointermove, para não forçar reflow
function measure() {
    min = slider.clientWidth - track.scrollWidth;
}

function limits(value) {

    const max = 0;

    if (value > max) return max;
    if (value < min) return min;

    return value;
}

// Só existe na Home: sem essa checagem o erro interrompe o restante do script nas outras páginas
if (slider && track) {

    track.addEventListener("pointerdown", e => {
        isDown = true;
        startX = e.clientX;
        measure();
        track.setPointerCapture(e.pointerId);
    });

    track.addEventListener("pointermove", e => {

        if (!isDown) return;

        current = limits(previous + (e.clientX - startX));

        track.style.transform = `translate3d(${current}px,0,0)`;
    });

    track.addEventListener("pointerup", () => {
        isDown = false;
        previous = current;
    });

    window.addEventListener("resize", () => {
        measure();
        previous = limits(previous);
        current = previous;
        track.style.transform = `translate3d(${current}px,0,0)`;
    });

}

/**card metodologia */
const wrapper = document.querySelector('.cards-metodologia');

if (wrapper) {
    wrapper.addEventListener('click', e => {
        const card = e.target.closest('.card-metodologia');
        if (!card) return;

        wrapper
            .querySelector('.active')
            ?.classList.remove('active');

        card.classList.add('active');
    });
}

/**filtro da listagem de Cases por área */
const filtroCases = document.querySelector('.filtro-cases');

if (filtroCases) {
    const cardsCases = document.querySelectorAll('.grid-cases .card-case');

    filtroCases.addEventListener('click', e => {
        const chip = e.target.closest('.filtro-cases__chip');
        if (!chip) return;

        const area = chip.dataset.filtro;

        filtroCases.querySelectorAll('.filtro-cases__chip').forEach(btn => {
            const ativo = btn === chip;
            btn.classList.toggle('is-active', ativo);
            btn.setAttribute('aria-pressed', ativo);
        });

        let visiveis = 0;
        cardsCases.forEach(card => {
            card.hidden = area !== '' && !card.dataset.areas.split(' ').includes(area);
            if (!card.hidden) visiveis++;
        });

        const vazio = document.getElementById('filtro-cases-vazio');
        if (vazio) vazio.hidden = visiveis > 0;
    });
}

/**voltar ao topo */
const footerTopBtn = document.querySelector('.footer-top');

if (footerTopBtn) {
    footerTopBtn.addEventListener('click', e => {
        e.preventDefault();
        // Rola a janela e também o html/body, caso algum deles seja o container de rolagem
        [window, document.documentElement, document.body].forEach(el => {
            el.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
}