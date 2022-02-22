<?php

namespace App;

error_reporting(1);

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;

class WikiKnowledgeGraph
{

    protected static $config = [];
    protected static $client;

    public static function setConfig($config = [])
    {

        self::$config = $config;
        $auth = Authenticate::basic(self::$config['username'], self::$config['password']);
        self::$client = ClientBuilder::create()
            ->withDriver('default', self::$config['bolt'], $auth)
            ->build();

    }


    public static function runGraphCategory()
    {

        self::$client->run('CREATE INDEX ON :Category(catId)');
        self::$client->run('CREATE INDEX ON :Page(pageTitle)');
        self::$client->run('CREATE INDEX ON :Category(catName)');
        self::$client->run("CREATE (c:Category:RootCategory {catId: 0, catName: '" . self::$config['rootcategory'] . "', subcatsFetched : false, pagesFetched : false, level: 0 })");

        $query = 'UNWIND range(0,2) as level
                    CALL apoc.cypher.doIt("
                    MATCH (c:Category { subcatsFetched: false, level: $level})
                    CALL apoc.load.json(\''.self::$config['hosturl'].'/w/api.php?format=json&action=query&list=categorymembers&cmtype=subcat&cmtitle=Category:\' + apoc.text.urlencode(c.catName) + \'&cmprop=ids|title&cmlimit=500\')
                    YIELD value as results
                    UNWIND results.query.categorymembers AS subcat
                    MERGE (sc:Category {catId: subcat.pageid})
                    ON CREATE SET sc.catName = substring(subcat.title,9),
                                  sc.subcatsFetched = false,
                                  sc.pagesFetched = false,
                                  sc.level = $level + 1
                    WITH sc,c
                    CALL apoc.create.addLabels(sc,[\'Level\' +  (sc.level) + \'Category\']) YIELD node
                    MERGE (sc)-[:SUBCAT_OF]->(c)
                    WITH DISTINCT c
                    SET c.subcatsFetched = true", { level: level }) YIELD value
                    RETURN value';

        $categorys = self::$client->run($query);

        return $categorys;

    }

    public static function runGraphPages()
    {

        $query = 'UNWIND range(0,1) as level
                    CALL apoc.cypher.doIt("
                    MATCH (c:Category { pagesFetched: false, level: $level })
                    CALL apoc.load.json(\''.self::$config['hosturl'].'/w/api.php?format=json&action=query&list=categorymembers&cmtype=page&cmtitle=Category:\' + apoc.text.urlencode(c.catName) + \'&cmprop=ids|title&cmlimit=500\')
                    YIELD value as results
                    UNWIND results.query.categorymembers AS page
                    MERGE (p:Page {pageId: page.pageid})
                    ON CREATE SET p.pageTitle = page.title, p.pageUrl = \'http://en.wikipedia.org/wiki/\' + apoc.text.urlencode(replace(page.title, \' \', \'_\'))
                    WITH p,c
                    MERGE (p)-[:IN_CATEGORY]->(c)
                    WITH DISTINCT c
                    SET c.pagesFetched = true", { level: level }) yield value
                    return value';

        $result = self::$client->run($query);

        return $result;
    }


    public static function runGraphPagesWithoutCategory()
    {

        $query = 'UNWIND range(0,2) as level
                    CALL apoc.cypher.doit("
                    MATCH (c:Category { pagesFetched: false, level: $level })
                    CALL apoc.load.json(\''.self::$config['hosturl'].'/w/api.php?action=query&format=json&list=allpages&aplimit=max\')
                    YIELD value as results
                    UNWIND results.query.categorymembers AS page
                    MERGE (p:Page {pageId: page.pageid})
                    ON CREATE SET p.pageTitle = page.title, p.pageUrl = \''.self::$config['hosturl'].'/wiki/\' + apoc.text.urlencode(replace(page.title, \' \', \'_\'))
                    WITH p,c
                    MERGE (p)-[:IN_CATEGORY]->(c)
                    WITH DISTINCT c
                    SET c.pagesFetched = true", { level: level }) yield value
                    return value';

        $result = self::$client->run($query);

        return $result;
    }

}