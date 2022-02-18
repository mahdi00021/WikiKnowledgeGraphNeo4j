<?php

$config = [];

$config['hosturl'] = 'https://mediawiki.com';

$config['bolt'] = 'bolt+s://user:password@localhost';

$config['rootcategory'] = 'Cars';

WikiKnowledgeGraph::setConfig($config);

$category = WikiKnowledgeGraph::runGraphCategory();

$pages = WikiKnowledgeGraph::runGraphPages();
