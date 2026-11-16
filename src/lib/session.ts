import { cookies } from "next/headers";
import { cache } from "react";
import { getMe } from "@/lib/api";

export const ACCESS_COOKIE = "raizes_access";
export const REFRESH_COOKIE = "raizes_refresh";

export function tokenCookie(maxAge: number) {
  return {
    httpOnly: true,
    sameSite: "lax" as const,
    secure: process.env.NODE_ENV === "production",
    path: "/",
    maxAge,
  };
}

export const getSession = cache(async () => {
  const jar = await cookies();
  const access = jar.get(ACCESS_COOKIE)?.value;
  if (!access) {
    return null;
  }

  const me = await getMe(access);
  if (!me.ok) {
    return me.status === 401 ? { expired: true as const } : null;
  }

  return {
    expired: false as const,
    token: access,
    user: me.user,
    permissions: me.permissions,
  };
});
