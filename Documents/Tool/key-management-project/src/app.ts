import express from 'express';
import { setKeyRoutes } from './routes/keyRoutes';

const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.json());

setKeyRoutes(app);

app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});