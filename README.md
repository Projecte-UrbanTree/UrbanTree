# UrbanTree

Aplicatiu web per a la gestió del manteniment d'arbrat urbà i periurbà.

<!-- Nomenclatura per a la Base de Dades moguda a la [wiki](https://github.com/Projecte-UrbanTree/UrbanTree/wiki/Naming-Conventions) -->

## Instruccions d'instal·lació

1. **Preparació de l'entorn de desenvolupament:**
   Abans de començar, has de garantir que tens Composer instal·lat a la teva màquina. Si no el tens, el pots descarregar des [d'aquí](https://getcomposer.org/).

   Executa el següent comandament per instal·lar les dependències del projecte:

   ```bash
   composer install
   ```

2. **Arrencar l'entorn amb Docker:**
   Un cop les dependències estiguin instal·lades, pots arrencar l'entorn de desenvolupament utilitzant Docker. Executa el següent comandament:
   ```bash
   docker-compose up --build --watch --remove-orphans
   ```

Això crearà els contenidors necessaris per al projecte i posarà en marxa l'aplicació.

---

Accedir a l'aplicació en entorn de desenvolupament: [http://localhost:8000](http://localhost:8000)

Accedir al phpMyAdmin:: [http://localhost:8080](http://localhost:8080)