export interface Service {
    id: number;
    name: string;
    description: string;
    category: ServiceCategory;
    main_email: ServiceEmail;
    emails: ServiceEmail[];
    main_phone: ServicePhone;
    phones: ServicePhone[];
    tags: ServiceTag[];
    main_image: ServiceImage;
    images: ServiceImage[];
    created_at: string;
    updated_at: string;
    deleted_at: string;
}

export interface ServiceCategory {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
}

export interface ServiceEmail {
    id: number;
    email: Email;
    created_at: string;
    updated_at: string;
}

export interface Email {
    email: string;
    domain: string;
}

export interface ServicePhone {
    id: number;
    number: string;
    created_at: string;
    updated_at: string;
}

export interface ServiceTag {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
}

export interface ServiceImage {
    id: number;
    url: string;
    created_at: string;
    updated_at: string;
}
