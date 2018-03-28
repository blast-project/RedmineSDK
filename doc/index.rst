===============
PHP Redmine SDK
===============

Quick Start
===========

Cette page fournis une rapide introduction au SDK, illustrée par des examples.

-----------------------
Créer une Configuration
-----------------------

.. code-block:: php

  use Blast\RedmineSDK\Config\BasicAuthConfig;

  $config =  new BasicAuthConfig(
    // Base URI of your Redmine API
    'https://redmine.example.org'
    //Your login and password
    'my_login', 'my password'
  );

La configuration se compose des informations nécessaires pour se connecter à l'API Redmine.
Elle est utilisée par l'ensemble des objets qui accède à l'API.

---------------------
Rechercher des Issues
---------------------

.. code-block:: php

  use Blast\RedmineSDK\Repository\IssueRepository;

  $issueRepo = new IssueRepository($config);
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

Un objet ``Result`` est retourné par les méthodes des repositories.
Cet objet contient les données formatées en tableau, l'objet ``Psr7\Response``
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

  $issueRepo = new IssueRepository($config);
  //find one issue by its id
  $issue = $issueRepo->find($issueId)->hydrate();
  $issue->set('subject', 'My new subject');
  $issueRepo->update($issue);


À partir d'un objet ``Issue``, il est possible de modifier une valeur et de mettre à jour l'issue sur Redmine.
Pour cela, la méthode ``Repository::update()`` est appelée sur l'issue à mettre à jour.
