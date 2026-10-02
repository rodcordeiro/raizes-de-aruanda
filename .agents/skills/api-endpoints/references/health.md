# Health

Reviewed 2026-09-21 from `src/modules/health/health.controller.ts`.
`VERSION_NEUTRAL` + global prefix → **`/api/health`**, not `/api/v1/health`.

## GET /api/health

- **Auth:** none
- **Params / body:** none
- **200:** Terminus payload when heap < 200MB and RSS < 3000MB:

```json
{
  "status": "ok",
  "info": {
    "memory_heap": { "status": "up" },
    "memory_rss": { "status": "up" }
  },
  "error": {},
  "details": {
    "memory_heap": { "status": "up" },
    "memory_rss": { "status": "up" }
  }
}
```

- **503:** same shape with `"status": "error"` when a memory check fails.
