declare global {
  namespace NodeJS {
    export interface ProcessEnv {
      VITE_CONN_URI: string;
      VITE_ICNT_MYSQL_USER: string;
      VITE_ICNT_MYSQL_PASSWORD: string;
      VITE_ICNT_MYSQL_DATABASE: string;
    }
  }
}
