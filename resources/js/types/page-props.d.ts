declare module '@inertiajs/core' {
  interface PageProps {
    auth: {
        user: {
            name: string;
            email: string;
            role: string;
            permissions: string[];
        };
    }
  }
}

export {}
