export class KeyModel {
    id: string;
    name: string;
    value: string;
    createdAt: Date;
    updatedAt: Date;

    constructor(id: string, name: string, value: string) {
        this.id = id;
        this.name = name;
        this.value = value;
        this.createdAt = new Date();
        this.updatedAt = new Date();
    }

    updateValue(newValue: string) {
        this.value = newValue;
        this.updatedAt = new Date();
    }

    toJSON() {
        return {
            id: this.id,
            name: this.name,
            value: this.value,
            createdAt: this.createdAt,
            updatedAt: this.updatedAt,
        };
    }
}