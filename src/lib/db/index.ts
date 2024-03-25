import { knex } from 'knex';
import { DB_CONFIG } from '@/lib/config/db.config';

export function connection() {
  return knex(DB_CONFIG);
}
