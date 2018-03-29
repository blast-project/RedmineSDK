===============
PHP Redmine SDK
===============

Quick Start
===========

Cette page fournis une rapide introduction au SDK, illustrée par des examples.

-----------------------
Créer une Connexion
-----------------------

.. code-block:: php

  use Blast\RedmineSDK\Connection\BasicConnection;

  $ctn =  new BasicConnection(
    // Base URI of your Redmine API
    'https://redmine.example.org'
    //Your login and password
    'my_login', 'my password'
  );

L'objet ``Connection`` se compose des informations nécessaires pour se connecter à l'API Redmine.
Il est utilisé par l'ensemble des objets qui accèdent à l'API.

---------------------
Rechercher des Issues
---------------------

.. code-block:: php

  use Blast\RedmineSDK\Repository\IssueRepository;

  $issueRepo = new IssueRepository($ctn);
  //find the first 10 issues
  $result = $issueRepo->findAll(['limit'=> 10]);

Les repositories sont le point d'entrée pour réaliser des recherches et accéder aux informations de Redmine.

--------------
L'objet Result
--------------

.. code-block:: php

  $result = $issueRepo->findAll(['limit'=> 10]);

  foreach($result as $issue){
    //...
  }

Un objet ``Result`` est retourné par les méthodes des repositories (findAll(), find(),...).
Cet objet contient les données formatées sous la forme d'un tableau, l'objet ``Psr7\Response``
et implémente les interfaces ``Iterator`` et ``ArrayAccess``.
Cela permet d'accéder aux informations de l'objet ``Response`` mais aussi d'itérer directement sur les données Redmine retournées.

Hydrater les objets
-------------------

.. code-block:: php

  $issues = $issueRepo->findAll(['limit'=> 10])->hydrate();

  foreach($issues as $issue){
    $id = $issue->get('id');
    $projectId = $issue->get('project')->get('id');
    //...
  }

À partir d'un objet ``Result``, il est possible de récupérer un objet ou une collection d'objets hydratés.
Dans l'exemple précédent, une collection de 10 objets de type ``Issue`` est récupérée via l'appel de la méthode ``Result::hydrate()``.

-----------------------
Mettre à jour une Issue
-----------------------

.. code-block:: php

  use Blast\RedmineSDK\Repository\IssueRepository;

  $issueRepo = new IssueRepository($cxn);
  //find one issue by its id
  $issue = $issueRepo->find($issueId)->hydrate();
  $issue->set('subject', 'My new subject');
  $issueRepo->update($issue);


À partir d'un objet ``Issue``, il est possible de modifier une valeur et de mettre à jour l'issue sur Redmine.
Pour cela, la méthode ``Repository::update()`` est appelée sur l'issue à mettre à jour.


----------------
Le QueryBuilder
----------------

.. code-block:: php

  use Blast\RedmineSDK\Query\QueryBuilder;

  $qb = new QueryBuilder();
  $qb
    ->include('journals')
    ->whereEq('project_id', 10)
    ->limit(15);

  $issueRepo = new IssueRepository($cxn);
  //find one issue by its id
  $issues = $issueRepo->findAll($qb->build())->hydrate();
  //...

Le ``QueryBuilder`` permet de construire la partie ``query`` de la requête http.
Le ``QueryBuilder`` peut être utiliser pour construire les arguments passés aux méthodes ``Repository::findAll()`` et ``Repository::find()``
pour filter, trier et paramétrer le résultat de la requête.
