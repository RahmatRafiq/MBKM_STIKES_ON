/// <reference types="vite/client" />

interface ImportMetaEnv {
    readonly VITE_APP_URL: string
    readonly VITE_APP_NAME: string
    readonly VITE_APP_ENV: string
    readonly VITE_COPYRIGHT_LABEL: string
    readonly VITE_COPYRIGHT_YEAR: string
    readonly VITE_COPYRIGHT_URL: string

    // readonly RECAPTCHA_SITE_KEY: string
    // readonly RECAPTCHA_SECRET_KEY: string
    // readonly VITE_RECAPTCHA_SITE_KEY: string
    // more env variables...
  }
