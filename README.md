# Urban Tree 5.0

Aplicatiu web per a la gestió del manteniment d'arbrat urbà i periurbà.

## Instruccions d'instal·lació

**1. Configurar les variables d'entorn**

En base al fitxer `.env.example`, crea un fitxer similar a la mateixa carpeta amb el nom `.env`, modificant les variables d'entorn per tal que s'adaptin a les teves necessitats.

**2. Arrencar l'entorn amb Docker**

Executa el següent comandament:

```bash
docker-compose up --build --watch --remove-orphans
```
Testos: `docker-compose -f compose.test.yml up --build --watch --remove-orphans`

Executar-ho crearà els contenidors necessaris per al projecte i posarà en marxa el projecte!

---
Aquestes són les URL's d'accés a les diferents parts de l'aplicació en entorn de desenvolupament:

- L'aplicatiu: [http://localhost:8000](http://localhost:8000)
- L'API: [http://localhost:8001](http://localhost:8001)
- El phpMyAdmin: [http://localhost:8080](http://localhost:8080)
