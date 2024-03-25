import { Knex } from 'knex';

import * as process from 'process';

export const DB_CONFIG = {
  client: 'mysql',
  connection: {
    host: process.env.VITE_CONN_URI,
    database: process.env.VITE_ICNT_MYSQL_DATABASE,
    user: process.env.VITE_ICNT_MYSQL_USER,
    password: process.env.VITE_ICNT_MYSQL_PASSWORD,
    requestTimeout: 60 * 1000, // seconds * ms
  },
  migrations: {
    tableName: 'tb_migrations',
    directory: './src/database/migrations',
  },
  debug: process.env.DB_DEBUG === 'true',
  //   log: KnexLogger,

  seeds: { directory: './src/database/seeds' },
} as Knex.Config<Knex.MySqlConnectionConfig>;
