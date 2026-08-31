(function () {
  "use strict";

  const mqMobile = window.matchMedia("(max-width: 768px)");

  /**
   * @returns {{ sheet: HTMLElement|null, scrim: HTMLElement|null, openBtn: HTMLElement|null, closeBtn: HTMLElement|null }}
   */
  function menuEls() {
    return {
      sheet: document.getElementById("nav-sheet"),
      scrim: document.getElementById("nav-scrim"),
      openBtn: document.getElementById("menu-open"),
      closeBtn: document.getElementById("menu-close"),
    };
  }

  /** @param {boolean} open */
  function setMenuOpen(open) {
    const { sheet, scrim, openBtn } = menuEls();
    if (!sheet) return;

    document.body.classList.toggle("nav-open", open);

    if (scrim) {
      scrim.hidden = !open;
    }

    if (openBtn) {
      openBtn.setAttribute("aria-expanded", open ? "true" : "false");
    }

    if (open && mqMobile.matches) {
      const filter = document.getElementById("nav-filter");
      if (filter) filter.focus();
    }
  }

  function syncNavA11y() {
    const { sheet, scrim, openBtn } = menuEls();
    if (!sheet) return;

    if (!mqMobile.matches) {
      document.body.classList.remove("nav-open");
      if (scrim) scrim.hidden = true;
      if (openBtn) openBtn.setAttribute("aria-expanded", "false");
      return;
    }

    const open = document.body.classList.contains("nav-open");
    if (scrim) scrim.hidden = !open;
    if (openBtn) openBtn.setAttribute("aria-expanded", open ? "true" : "false");
  }

  function initMenu() {
    const { sheet, scrim, openBtn, closeBtn } = menuEls();
    if (!sheet || !openBtn) return;

    openBtn.addEventListener("click", function () {
      setMenuOpen(true);
    });

    if (closeBtn) {
      closeBtn.addEventListener("click", function () {
        setMenuOpen(false);
      });
    }

    if (scrim) {
      scrim.addEventListener("click", function () {
        setMenuOpen(false);
      });
    }

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") setMenuOpen(false);
    });

    if (typeof mqMobile.addEventListener === "function") {
      mqMobile.addEventListener("change", syncNavA11y);
    } else if (typeof mqMobile.addListener === "function") {
      mqMobile.addListener(syncNavA11y);
    }

    syncNavA11y();
  }

  function initNavFilter() {
    const input = document.getElementById("nav-filter");
    if (!input) return;

    const categories = Array.prototype.slice.call(
      document.querySelectorAll(".nav-category")
    );

    input.addEventListener("input", function () {
      const q = (input.value || "").trim().toLocaleLowerCase("pt-BR");

      categories.forEach(function (category) {
        const links = Array.prototype.slice.call(
          category.querySelectorAll(".nav-line")
        );
        let visible = 0;

        links.forEach(function (link) {
          const name = link.getAttribute("data-linha") || link.textContent || "";
          const match = !q || name.indexOf(q) !== -1;
          link.classList.toggle("is-hidden", !match);
          if (link.parentElement) {
            link.parentElement.hidden = !match;
          }
          if (match) visible += 1;
        });

        category.classList.toggle("is-hidden", visible === 0);
      });
    });
  }

  function initRitmoChips() {
    const chips = Array.prototype.slice.call(
      document.querySelectorAll(".ritmo-chip")
    );
    const pontos = Array.prototype.slice.call(
      document.querySelectorAll(".ponto")
    );
    if (!chips.length || !pontos.length) return;

    const main = document.getElementById("main");

    /**
     * @param {string} pontoId
     */
    function scrollToPonto(pontoId) {
      const target = document.getElementById(pontoId);
      if (!target) return;

      target.scrollIntoView({ block: "start", behavior: "smooth" });
    }

    /**
     * @param {string} ritmoKey
     */
    function setActiveChipByRitmo(ritmoKey) {
      chips.forEach(function (chip) {
        chip.classList.toggle(
          "is-active",
          (chip.getAttribute("data-ritmo") || "") === ritmoKey
        );
      });
    }

    /**
     * @param {string} pontoId
     */
    function setActiveChipFromPonto(pontoId) {
      const ponto = document.getElementById(pontoId);
      if (!ponto) return;
      const ritmoKey = ponto.getAttribute("data-ritmo") || "";
      if (ritmoKey) setActiveChipByRitmo(ritmoKey);
    }

    chips.forEach(function (chip) {
      chip.addEventListener("click", function (event) {
        const href = chip.getAttribute("href") || "";
        const pontoId =
          chip.getAttribute("data-ponto-id") ||
          (href.charAt(0) === "#" ? href.slice(1) : "");
        const ritmoKey = chip.getAttribute("data-ritmo") || "";
        if (!pontoId || !document.getElementById(pontoId)) return;

        event.preventDefault();
        if (ritmoKey) setActiveChipByRitmo(ritmoKey);
        scrollToPonto(pontoId);

        if (history.replaceState) {
          history.replaceState(null, "", "#" + pontoId);
        }
      });
    });

    if (location.hash) {
      const hashId = location.hash.slice(1);
      if (document.getElementById(hashId)) {
        setActiveChipFromPonto(hashId);
        requestAnimationFrame(function () {
          scrollToPonto(hashId);
        });
      }
    }

    if (!("IntersectionObserver" in window)) return;

    const observer = new IntersectionObserver(
      function (entries) {
        let visibleRitmo = null;
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          visibleRitmo = entry.target.getAttribute("data-ritmo") || null;
        });
        if (visibleRitmo) setActiveChipByRitmo(visibleRitmo);
      },
      {
        root: main,
        rootMargin: "-20% 0px -55% 0px",
        threshold: 0,
      }
    );

    pontos.forEach(function (ponto) {
      observer.observe(ponto);
    });
  }

  function initIcons() {
    if (typeof feather !== "undefined" && feather.replace) {
      feather.replace();
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    initIcons();
    initMenu();
    initNavFilter();
    initRitmoChips();
  });
})();
