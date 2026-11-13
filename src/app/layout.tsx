import type { Metadata } from "next";
import { Source_Sans_3 } from "next/font/google";
import "./globals.css";

const sourceSans = Source_Sans_3({
  subsets: ["latin"],
  weight: ["400", "600", "700"],
  variable: "--font-sans",
});

export const dynamic = "force-dynamic";

export const metadata: Metadata = {
  title: "Pontos de Umbanda — Raízes de Aruanda",
  description: "Catálogo de pontos da Curimba do terreiro Raízes de Aruanda.",
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="pt-br" className={sourceSans.variable}>
      <body>{children}</body>
    </html>
  );
}
