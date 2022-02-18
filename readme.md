Package for send query to neo4j server database for wiki knowledge graph backend and front with neovis.js for display graphs from neo4j in php
please put 
in your path from mediawiki

cli : composer update


-----------------------------With Category and pages subcategory-------------------------------------

$config = [];
$config['hosturl'] = 'https://mediawiki.com';
$config['bolt'] = 'bolt+s://user:password@localhost';
$config['rootcategory'] = 'Cars';


WikiKnowledgeGraph::setConfig($config);
$pages = WikiKnowledgeGraph::runGraphPages();
$category = WikiKnowledgeGraph::runGraphCategory();

-----------------------------------------------------------------------------------------------------



-----------------------------all pages without category----------------------------------------------

$config = [];
$config['hosturl'] = 'https://mediawiki.com';
$config['bolt'] = 'bolt+s://user:password@localhost';


WikiKnowledgeGraph::setConfig($config);
$pages = WikiKnowledgeGraph::runGraphPagesWithoutCategory();


-----------------------------------------------------------------------------------------------------

