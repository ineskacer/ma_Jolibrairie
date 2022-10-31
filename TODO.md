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



## A faire

- Charger des données dans les data fixtures
- Création de l'entité membre

## Problèmes rencontrés



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