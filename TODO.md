# Projet PHP **ma_Jolibrairie**

## Apprentissage PHP

- J'en suis au TP6 que j'ai fini

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



## A faire

- Ajout de données de tests dans App Fixtures pour l'entité membre

## Problèmes rencontrés

- Lors du chargement de données de tests pour amateur : problème lors de fixtures load -n "warning: undefined array key 2"
- J'ai supprimé le code de app fixtures où j'ai tenté de rajouté des données pour amateurs : on réessaye plus tard


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