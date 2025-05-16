export interface Key {
    id: string;
    value: string;
    createdAt: Date;
    updatedAt: Date;
}

export interface KeyData {
    value: string;
    expirationDate?: Date;
}