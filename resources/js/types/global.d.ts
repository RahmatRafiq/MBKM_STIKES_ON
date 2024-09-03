import { AxiosInstance } from 'axios'
// import ziggyRoute from 'ziggy-js'

export { }

declare global {
    interface Window {
        axios: AxiosInstance;
    }
    // export const route: typeof ziggyRoute
}

