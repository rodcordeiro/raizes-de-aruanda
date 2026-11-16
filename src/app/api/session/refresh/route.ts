import { cookies } from "next/headers";
import { NextResponse } from "next/server";
import { apiFetch } from "@/lib/api";
import { ACCESS_COOKIE, REFRESH_COOKIE, tokenCookie } from "@/lib/session";

export async function GET(request: Request) {
  const jar = await cookies();
  const refresh = jar.get(REFRESH_COOKIE)?.value;
  const login = new URL("/admin/login", request.url);

  if (!refresh) {
    jar.set(ACCESS_COOKIE, "", tokenCookie(0));
    return NextResponse.redirect(login);
  }

  const response = await apiFetch("/api/v1/auth/refresh", {
    method: "POST",
    body: JSON.stringify({ refreshToken: refresh }),
  });

  if (!response.ok) {
    jar.set(ACCESS_COOKIE, "", tokenCookie(0));
    jar.set(REFRESH_COOKIE, "", tokenCookie(0));
    return NextResponse.redirect(login);
  }

  const body = (await response.json()) as { accessToken?: string; refreshToken?: string };
  if (!body.accessToken || !body.refreshToken) {
    jar.set(ACCESS_COOKIE, "", tokenCookie(0));
    jar.set(REFRESH_COOKIE, "", tokenCookie(0));
    return NextResponse.redirect(login);
  }

  jar.set(ACCESS_COOKIE, body.accessToken, tokenCookie(60 * 60));
  jar.set(REFRESH_COOKIE, body.refreshToken, tokenCookie(60 * 60 * 24 * 10));

  const next = new URL(request.url).searchParams.get("next");
  const target = next && next.startsWith("/admin") ? next : "/admin/pontos";
  return NextResponse.redirect(new URL(target, request.url));
}
