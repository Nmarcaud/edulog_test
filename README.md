# Test Edulog

> J'ai utilisé API Platform 

1. Créer un projet Symfony 4, 5 ou 6 (au choix) associé avec une base de données où on aura pris le soin de charger les données du fichier ci-joint ✅

2. Créer une API REST qui peut être appelée par la route /api/nextdeadlines.  
> ✅ La route est bien appelable à cette adresse


3. Elle retourne une liste des deadlines issues de la base de données, qui ne sont pas marquées comme clôturées et qui ont leur date d’échéance avant le vendredi de la semaine prochaine inclus :
- L’intitulé de la deadline ✅ 
- Le nombre de jours avant échéance 
> ❌ pas dans le point 3 / ✅ ok dans le point 4 
- Un flag “EN RETARD” à true si la date est dépassée
> ❌ pas dans le point 3 / ✅ ok dans le point 4 
- Un rappel de la date d’échéance ✅ 

4. Une autre route est disponible /api/alldeadlines montre toutes les deadlines, non réalisées, sans limite de date. Toujours avec le même schéma de retour. ✅ 
> ✅ La route est bien appelable à cette adresse et affiche tous les résultats


5. Cette API doit permettre de marquer une deadline comme réalisée. Il faut que l’on puisse appeler l’API, on sait pas encore trop comment, mais ça doit changer le flag “is_done” dans la base. Le développeur front a dit “faites au mieux”, donc : à vous de jouer ! ✅ 
> ✅ Route "/api/deadline/{id}/isDone". Il faut juste renseigner l'id et utiliser la méthode PUT


6. Ecrire un fichier readme.md à la racine du projet qui explique comment l’installer et appeler l’API ✅ 