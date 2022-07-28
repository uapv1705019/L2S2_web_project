La "page d'accueil" du projet est le fichier utilisateurs.php

Pour la Partie 2 question 4, il fallait régler le statut 'admin' manuellement dans la base de donnée : 

ALTER TABLE utilisateurs
ADD admin text

ce code permet d'ajouter la colonne admin dans la table utilisateurs.

j'ai prévu d'ajouter un utilisateur, Laurent PEREIRA, qui aurait comme id "1" et le statut admin en true (lui seul a ce statut, tous les autres seront en false)
tout d'abord, je donne le statut admin en false à tous les utilisateurs déjà enregistrés dans la BDD

UPDATE utilisateurs
SET admin = 'false'

ensuite je crée l'utilisateur qui aura le statut admin : 

INSERT INTO utilisateurs (id, prenom, nom, admin)
VALUES ('1', 'Laurent', 'Pereira', 'true')

ces 3 requêtes ont été exécutées directement dans la BDD via PuTTY, elles ne seront pas visibles dans le code du mini-projet