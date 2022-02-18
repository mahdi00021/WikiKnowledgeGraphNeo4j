<?php

require 'vendor/autoload.php';

use App\WikiKnowledgeGraph;


$config = [];

$config['hosturl'] = 'https://en.wikipedia.org';
$config['username'] = '';
$config['password'] = '';
$config['bolt'] = 'bolt+s://b9c3d365a1341b62c2526a5fd5ff0041.neo4jsandbox.com:7687';
$config['rootcategory'] = 'Cars';

WikiKnowledgeGraph::setConfig($config);

WikiKnowledgeGraph::runGraphCategory();

WikiKnowledgeGraph::runGraphPages();


