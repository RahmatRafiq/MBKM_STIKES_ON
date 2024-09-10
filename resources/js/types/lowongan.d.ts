export default interface Lowongan {
    id?: number
    name?: string
    description?: string
    quota?: string
    is_open?: string
    location?: string
    gpa?: string
    semester?: string
    experience_required?: string
    start_date?: string
    end_date?: string
    month_duration?: string
    mitra?: Mitra
}

export interface Mitra {
    id?: number
    name?: string
    user_id?: string
    address?: string
    phone?: string
    email?: string
    website?: string
    type?: string
    description?: string
    image_url?: string
    others?: Lowongan[]
}

export interface LowonganApiResponse {
    current_page: number;
    data: Lowongan[]; // Array dari objek Lowongan
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}

export interface FilterLowonganResponse {
    status: string;
    message: string;
    data: LowonganApiResponse;
}
