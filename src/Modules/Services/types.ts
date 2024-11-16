export interface Service {
    id?: number | null;
    name: string | null;
    description?: string | null;
    category?: ServiceCategory | null;
    main_email?: ServiceEmail | null;
    emails?: ServiceEmail[] | null;
    main_phone?: ServicePhone | null;
    phones?: ServicePhone[] | null;
    tags?: ServiceTag[] | null;
    main_image?: ServiceImage | null;
    images?: ServiceImage[] | null;
    created_at?: string | null;
    updated_at?: string | null;
    deleted_at?: string | null;
}

export interface ServiceCategory {
    id?: number | null;
    name: string | null;
    created_at?: string | null;
    updated_at?: string | null;
}

export interface ServiceEmail {
    id?: number | null;
    email: Email | null;
    created_at?: string | null;
    updated_at?: string | null;
}

export interface Email {
    value: string | null;
    domain?: string | null;
}

export interface ServicePhone {
    id?: number | null;
    number: string | null;
    created_at?: string | null;
    updated_at?: string | null;
}

export interface ServiceTag {
    id?: number | null;
    name: string | null;
    created_at?: string | null;
    updated_at?: string | null;
}

export interface ServiceImage {
    url: string | null;
    created_at?: string | null;
    updated_at?: string | null;
}
