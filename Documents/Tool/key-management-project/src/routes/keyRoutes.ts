import { Router } from 'express';
import KeyController from '../controllers/keyController';

const router = Router();
const keyController = new KeyController();

export default function setKeyRoutes(app) {
    app.use('/api/keys', router);
    
    router.post('/', keyController.createKey.bind(keyController));
    router.get('/:id', keyController.getKey.bind(keyController));
    router.put('/:id', keyController.updateKey.bind(keyController));
    router.delete('/:id', keyController.deleteKey.bind(keyController));
}