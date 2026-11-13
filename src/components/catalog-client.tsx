"use client";

import { useEffect } from "react";

export function CatalogClient({ activeKey }: { activeKey: string }) {
  useEffect(() => {
    const media = window.matchMedia("(max-width: 768px)");
    const sheet = document.getElementById("nav-sheet");
    const scrim = document.getElementById("nav-scrim");
    const openBtn = document.getElementById("menu-open");
    const closeBtn = document.getElementById("menu-close");
    const filter = document.getElementById("nav-filter") as HTMLInputElement | null;
    if (!sheet || !openBtn) {
      return;
    }

    const setOpen = (open: boolean) => {
      document.body.classList.toggle("nav-open", open);
      if (scrim) {
        scrim.hidden = !open;
      }
      openBtn.setAttribute("aria-expanded", open ? "true" : "false");
      if (open && media.matches) {
        filter?.focus();
      }
    };

    const onOpen = () => setOpen(true);
    const onClose = () => setOpen(false);
    const onKey = (event: KeyboardEvent) => {
      if (event.key === "Escape") {
        setOpen(false);
      }
    };
    const onMedia = () => {
      if (!media.matches) {
        setOpen(false);
      }
    };
    const onFilter = () => {
      const query = (filter?.value ?? "").trim().toLocaleLowerCase("pt-BR");
      document.querySelectorAll(".nav-category").forEach((category) => {
        const links = category.querySelectorAll(".nav-line");
        let visible = 0;
        links.forEach((link) => {
          const name = (link.getAttribute("data-linha") || link.textContent || "").toLocaleLowerCase("pt-BR");
          const match = query === "" || name.includes(query);
          link.classList.toggle("is-hidden", !match);
          if (link.parentElement) {
            link.parentElement.hidden = !match;
          }
          if (match) {
            visible += 1;
          }
        });
        category.classList.toggle("is-hidden", visible === 0);
      });
    };

    openBtn.addEventListener("click", onOpen);
    closeBtn?.addEventListener("click", onClose);
    scrim?.addEventListener("click", onClose);
    document.addEventListener("keydown", onKey);
    media.addEventListener("change", onMedia);
    filter?.addEventListener("input", onFilter);

    const chips = Array.from(document.querySelectorAll<HTMLAnchorElement>(".ritmo-chip"));
    const pontos = Array.from(document.querySelectorAll<HTMLElement>(".ponto"));
    const chipHandlers: Array<[HTMLAnchorElement, (event: Event) => void]> = [];
    let observer: IntersectionObserver | undefined;

    if (chips.length > 0 && pontos.length > 0) {
      const setActive = (key: string) => {
        chips.forEach((chip) => {
          chip.classList.toggle("is-active", (chip.getAttribute("data-ritmo") || "") === key);
        });
      };
      const scrollToPoint = (id: string) => {
        document.getElementById(id)?.scrollIntoView({ block: "start", behavior: "smooth" });
      };

      chips.forEach((chip) => {
        const onChip = (event: Event) => {
          const id = chip.getAttribute("data-ponto-id") || "";
          const key = chip.getAttribute("data-ritmo") || "";
          if (!id || !document.getElementById(id)) {
            return;
          }
          event.preventDefault();
          if (key) {
            setActive(key);
          }
          scrollToPoint(id);
          history.replaceState(null, "", `#${id}`);
        };
        chip.addEventListener("click", onChip);
        chipHandlers.push([chip, onChip]);
      });

      if (location.hash) {
        const id = location.hash.slice(1);
        const ponto = document.getElementById(id);
        const key = ponto?.getAttribute("data-ritmo");
        if (key) {
          setActive(key);
        }
        if (ponto) {
          requestAnimationFrame(() => scrollToPoint(id));
        }
      }

      if ("IntersectionObserver" in window) {
        observer = new IntersectionObserver(
          (entries) => {
            let visible: string | null = null;
            entries.forEach((entry) => {
              if (!entry.isIntersecting) {
                return;
              }
              visible = (entry.target as HTMLElement).getAttribute("data-ritmo");
            });
            if (visible) {
              setActive(visible);
            }
          },
          { root: document.getElementById("main"), rootMargin: "-20% 0px -55% 0px", threshold: 0 },
        );
        pontos.forEach((ponto) => observer?.observe(ponto));
      }
    }

    return () => {
      openBtn.removeEventListener("click", onOpen);
      closeBtn?.removeEventListener("click", onClose);
      scrim?.removeEventListener("click", onClose);
      document.removeEventListener("keydown", onKey);
      media.removeEventListener("change", onMedia);
      filter?.removeEventListener("input", onFilter);
      chipHandlers.forEach(([chip, handler]) => chip.removeEventListener("click", handler));
      observer?.disconnect();
      document.body.classList.remove("nav-open");
    };
  }, [activeKey]);

  return null;
}
