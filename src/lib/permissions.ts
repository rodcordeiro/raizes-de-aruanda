/**
 * `permissions` ausente ou vazio significa que a API ainda não informou o papel.
 * Nesse caso a UI mostra as ações e a API responde 403.
 * Lista preenchida esconde o que o slug não cobre, inclusive `recurso:*`.
 */
export function can(permissions: string[] | undefined, slug: string): boolean {
  if (!permissions || permissions.length === 0) {
    return true;
  }

  if (permissions.includes(slug)) {
    return true;
  }

  const separator = slug.indexOf(":");
  if (separator === -1) {
    return false;
  }

  return permissions.includes(`${slug.slice(0, separator)}:*`);
}

export function canReadCatalog(permissions: string[] | undefined): boolean {
  return can(permissions, "ponto:create") || can(permissions, "ponto:update");
}
