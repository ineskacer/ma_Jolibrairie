# Projet PHP **ma_Jolibrairie**

## Apprentissage PHP

- J'ai fais le TP7
- Je vais sauter le TP8 pour le moment

## Suivi du projet

`30/10` : 
- projet bug sur de nombreux points, je recommence tout depuis le début
- création du projet
- création du dépôt local
- création du dépôt distant 
- Push vers le dépôt distant
- création de l'entité Librairie
- création de l'entité Livre
- Mise en place de la relation OneToMany entre Librairie et Livre
- Création de la bdd 

`31/10`
- Chargement des données dans la bdd
- Initialisation d'Easy Admin
- Arrêt au guide de réalisation à l'ajout de crud

`1/11`
- Création de LibrairieCrudController.php
- Il y a bien quelque chose qui s'affiche quand je vais sur le /admin 
- Je peux ajouter/modifier/supprimer/consulter des librairies
- Création de LivreCrudController.php
- Il n'y a pas encore de liens entre librairie et livre
- Création de l'entité Amateur [membre]
- *Livres de Denden est une librairie ajoutée via Easy Admin et non via App Fixtures'

`2/11`
- Recréation de l'entité Amateur => correction de la proprité *nullable* de ***description***
- Ajout des données pour l'entité Amateur dans data fixtures ET CA MARCHE ENFIN PUREE
- Ajout d'un controller pour librairie
- La page / est consultable : on y voit la liste des librairies
- Les pages /librairies/{id} sont consultables
- Le bouton retour est opérationnel
- Ajout de la liste des films pour chaque librairie dans Easy Admin
- Ajout d'un controller crud pour Amateur dans Easy Admin
- Ajout d'un lien avec AssociationField() entre Amateur et Librairie

`3/11`
- Création de LivreController.php
- On peut consulter les livres d'une librairie

`7/11`
- Ajout de la liste des entités liés dans la page de détails 
- Intégration de Bootstrap dans mes templates
- Ajout d'un controller pour amateur
- Bootstrap pour amateur

`10/11`
- Ajout de l'entité genre en OneToMany avec livre et en ManyToOne avec amateur
- Modification de l'affichage de librairie_show et de amateur_show => plus joli maintenant
- Ajout d'un footer et changement de couleur du footer
- Ajout de show et index pour genre
- On peut aller d'un genre aux livres du genre

`11/10` 
- Ajout de l'entité Etalage
- Ajout d'un controller crud pour Etalage
- Migrations
- Ajout des messages flash
- Ajout de la balise button pour plusieurs liens pour faire plus joli

`12/10`
- Ajout de crud pour livre
- Ajout de crud pour librairie

`13/10`
- Ajout de crud pour Genre
- Ajout de la relation Amatateur -> Librairie -> Livre pour les ajouts

## A faire



## Problèmes rencontrés

- Je n'arrive pas à ajouter plusieurs livres dans ma galerie

## Notes à moi-même

- Je ne peux pas ajouter des livres dans ma librairie car mes livres sont en relations ManyToOne avec mes librairies donc il faut que je créer un livre pour l'ajouter.
- Pour ajouter des livres dans une librairie, ça se fait lors de la création du livre. 

## Commandes pratiques

- *Créer une entité*

```
symfony console make:entity
```
- *Créer une base de donnée* ou *Recréation de la bdd*
```
symfony console doctrine:database:create
```
- *Créer le schema de la base de donnée* ou *Recréation du schéma*
```
symfony console doctrine:schema:create
```
- *Mise à jour de la base de donnée*
```
symfony console doctrine:schema:update
```
- *Supprimer une base de donnée*
```
symfony console doctrine:database:drop --force
```
- *Charger des données dans la bdd*

```
symfony console doctrine:fixtures:load -n
```

- *Pour que l'ajout de données dans la bdd se passe bien pour une relation de type OneToMany*

***Cette commande est à mettre dans Entity/Librairie.php puisque c'est Librairie qui est en OneToMany avec Livre***
```
#[ORM\OneToMany(mappedBy: 'librairie', targetEntity: Livre::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $livres;
```

- *Consulter la bdd* 
```
symfony console dbal:run-sql 'SELECT * FROM film'
```
```
symfony console dbal:run-sql 'SELECT * FROM recommendation where film_id=2'
```
- *Pour consulter les routes*
``` 
symfony console debug:route
```
- *Ajouter un controller CRUD*
```
symfony console make:admin:crud
```
- *Pour ajouter un controller*
```
symfony console make:controller [Inventaire]Controller
```