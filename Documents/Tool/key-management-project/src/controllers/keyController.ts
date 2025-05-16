import { Request, Response } from 'express';
import { KeyService } from '../services/keyService';

export class KeyController {
    private keyService: KeyService;

    constructor() {
        this.keyService = new KeyService();
    }

    public createKey = async (req: Request, res: Response): Promise<void> => {
        try {
            const keyData = req.body;
            const newKey = await this.keyService.createKey(keyData);
            res.status(201).json(newKey);
        } catch (error) {
            res.status(500).json({ message: error.message });
        }
    };

    public getKey = async (req: Request, res: Response): Promise<void> => {
        try {
            const keyId = req.params.id;
            const key = await this.keyService.getKey(keyId);
            if (key) {
                res.status(200).json(key);
            } else {
                res.status(404).json({ message: 'Key not found' });
            }
        } catch (error) {
            res.status(500).json({ message: error.message });
        }
    };

    public updateKey = async (req: Request, res: Response): Promise<void> => {
        try {
            const keyId = req.params.id;
            const keyData = req.body;
            const updatedKey = await this.keyService.updateKey(keyId, keyData);
            if (updatedKey) {
                res.status(200).json(updatedKey);
            } else {
                res.status(404).json({ message: 'Key not found' });
            }
        } catch (error) {
            res.status(500).json({ message: error.message });
        }
    };

    public deleteKey = async (req: Request, res: Response): Promise<void> => {
        try {
            const keyId = req.params.id;
            const result = await this.keyService.deleteKey(keyId);
            if (result) {
                res.status(204).send();
            } else {
                res.status(404).json({ message: 'Key not found' });
            }
        } catch (error) {
            res.status(500).json({ message: error.message });
        }
    };
}