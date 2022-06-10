# newswebs1

Nous allons partir d'une DB que nous avons déjà installée:

`datas/newswebs1.sql`

## Requis

- php v8.0.*
- composer
- symfony.exe ( https://symfony.com/download )
- node.js et npm

## Installation

dans la console

        symfony new newswebs1 --webapp
        ou
        composer create-project symfony/skeleton newswebs1

Pour activer le SSL (https) :

        symfony server:ca:install

Puis on entre dans le dossier

        cd newswebs1
        symfony serve -d

Vous pouvez afficher le site à cette URL:

https://127.0.0.1:8000

Pour l'éteindre :

        symfony server:stop

## Configuration

Enregistrez .env en `.env.local` et modifiez ces lignes pour que la DB soit celle choisie pour le projet :

        # DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
        DATABASE_URL="mysql://root:@127.0.0.1:3307/newswebs1?charset=utf8"

## mapping de nos tables

dans la console :

        php bin/console doctrine:mapping:import App\\Entity annotation --path=src/Entity

Nos fichiers de mapping sont créés dans Symfony

Mais pour ajouter les setters, getters et fonctions de liens, il faut taper:

        php bin/console make:entity --regenerate

## création du premier CRUD

Dans la console

        php bin/console make:crud

Et on choisi le `src/Entity` que l'on souhaite, ici : Thearticle

On peut voir ce CRUD à l'url

https://127.0.0.1:8000/thearticle/

Il risque d'y avoir des erreurs car les instances de classes ne sont pas affichables depuis celle-ci: on va utiliser __tostring dans les classes liées aux articles :

        src/Entity/Thecomment.php
        ...
        public function __tostring():string {
            return $this->getThecommenttext();
        }

## npm

On va vérifier qu'on a la dernière version de npm et installer les composants nécessaires:

        npm install

On va "construire les fichiers js et css publiques" grâce à webpack-encore

        npm run build

## création du contrôlleur

        php bin/console make:controller

On le nomme PublicController et on met le chemin vers la racine du site (/)

On peut voir les vues ici :

        php bin/console debug:router


Dans le fichier `src/Controller/PublicController.php`
on va appeler les 3 derniers articles pour la homepage :

        ...
        // pour gérer les articles
        use App\Entity\Thearticle;
        // pour utiliser Doctrine
        use Doctrine\ORM\EntityManagerInterface;
        ...
        class PublicController extends AbstractController
        {
            #[Route('/', name: 'app_public')]
            public function index(EntityManagerInterface $entityManager): Response
            {
                // 3 derniers articles
                $threeArticles = $entityManager->getRepository(Thearticle::class)->findBy(['thearticleactivate'=>1],['thearticledate'=>'DESC'],3);
                return $this->render('public/index.html.twig', [
                'articles' => $threeArticles,
                ]);
            }
        }

On peut ensuite constater que la vue effectuera elle-même les requêtes suivant ce que l'on veut afficher !

        templates/public/index.html.twig
        ...
        {% for item in articles %}
        <h3>{{ item.thearticletitle }}</h3>
        <p>Nombre de commentaire : {{ item.thecommentIdthecomment.count }}   </p>
        <p>Rubrique : {% for rub in item.thesectionIdthesection %}
            <a href="./section/{{ rub.getThesectionslug }}">{{ rub.getThesectiontitle }}</a>
            {% endfor %}</p>
        <p>Ecrit par {{ item.theuserIdtheuser.theuserlogin }} le {{ item.thearticledate|date("d/m/Y à H:i") }}</p>
        <p>{{ item.thearticleresume }} ... <a href="./article/{{ item.thearticleslug }}">Lire la suite</a></p>
        {% else %}
        {% endfor %}

