La "page d'accueil" du projet est le fichier utilisateurs.php

Pour la Partie 2 question 4, il fallait r�gler le statut 'admin' manuellement dans la base de donn�e : 

ALTER TABLE utilisateurs
ADD admin text

ce code permet d'ajouter la colonne admin dans la table utilisateurs.

j'ai pr�vu d'ajouter un utilisateur, Laurent PEREIRA, qui aurait comme id "1" et le statut admin en true (lui seul a ce statut, tous les autres seront en false)
tout d'abord, je donne le statut admin en false � tous les utilisateurs d�j� enregistr�s dans la BDD

UPDATE utilisateurs
SET admin = 'false'

ensuite je cr�e l'utilisateur qui aura le statut admin : 

INSERT INTO utilisateurs (id, prenom, nom, admin)
VALUES ('1', 'Laurent', 'Pereira', 'true')

ces 3 requ�tes ont �t� ex�cut�es directement dans la BDD via PuTTY, elles ne seront pas visibles dans le code du mini-projet