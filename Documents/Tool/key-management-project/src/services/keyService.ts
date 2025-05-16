import { v4 as uuidv4 } from 'uuid';

export class KeyService {
    private keys: Map<string, string>;

    constructor() {
        this.keys = new Map();
    }

    generateKey(): string {
        const key = uuidv4();
        this.keys.set(key, key);
        return key;
    }

    validateKey(key: string): boolean {
        return this.keys.has(key);
    }

    storeKey(key: string): void {
        if (!this.keys.has(key)) {
            this.keys.set(key, key);
        }
    }

    deleteKey(key: string): boolean {
        return this.keys.delete(key);
    }

    getAllKeys(): string[] {
        return Array.from(this.keys.keys());
    }
}