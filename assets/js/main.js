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

  function initYoutubePlaceholders() {
    document.addEventListener("click", function (event) {
      const target = event.target;
      if (!(target instanceof Element)) return;

      const btn = target.closest(".yt-placeholder");
      if (!btn) return;

      const id = btn.getAttribute("data-youtube-id");
      if (!id) return;

      const iframe = document.createElement("iframe");
      iframe.className = "yt-embed";
      iframe.src =
        "https://www.youtube.com/embed/" +
        encodeURIComponent(id) +
        "?autoplay=1";
      iframe.title = "YouTube video player";
      iframe.setAttribute("allowfullscreen", "");
      iframe.allow =
        "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share";
      iframe.referrerPolicy = "strict-origin-when-cross-origin";

      btn.replaceWith(iframe);
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

    chips.forEach(function (chip) {
      chip.addEventListener("click", function () {
        chips.forEach(function (c) {
          c.classList.remove("is-active");
        });
        chip.classList.add("is-active");
      });
    });

    if (!("IntersectionObserver" in window)) return;

    const byId = {};
    pontos.forEach(function (ponto) {
      byId[ponto.id] = ponto;
    });

    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          const id = entry.target.id;
          chips.forEach(function (chip) {
            const href = chip.getAttribute("href") || "";
            chip.classList.toggle("is-active", href === "#" + id);
          });
        });
      },
      {
        root: null,
        rootMargin: "-40% 0px -50% 0px",
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
    initYoutubePlaceholders();
    initRitmoChips();
  });
})();
