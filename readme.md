<?php
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

