<?php
use Laudis\Neo4j\ClientBuilder;

class WikiKnowledgeGraph
{

	protected $config = [];
	protected $client;
	
	public static function setConfig($config = [])
	{
		$this->config = $config;
		$this->client = ClientBuilder::create()->withDriver('default', $this->config['bolt'])->build();
	}
	
	
	public static function runGraphCategory()
	{
	
		$this->client->run('CREATE INDEX ON :Category(catId)');
		$this->client->run('CREATE INDEX ON :Page(pageTitle)');
		$this->client->run('CREATE INDEX ON :Category(catName)');
		$this->client->run('CREATE (c:Category:RootCategory {catId: 0, catName: '.$this->config['rootcategory'].', subcatsFetched : false, pagesFetched : false, level: 0 }');

		$categorys = $this->client->run("
				UNWIND range(0,3) as level
				CALL apoc.cypher.doIt('
				MATCH (c:Category { subcatsFetched: false, level: $level})
				CALL apoc.load.json(".$this->config['hosturl']."/w/api.php?format=json&action=query&list=categorymembers&cmtype=subcat&cmtitle=Category:' + apoc.text.urlencode(c.catName) + '&cmprop=ids|title&cmlimit=500')
				YIELD value as results
				UNWIND results.query.categorymembers AS subcat
				MERGE (sc:Category {catId: subcat.pageid})
				ON CREATE SET sc.catName = substring(subcat.title,9),
							  sc.subcatsFetched = false,
							  sc.pagesFetched = false,
							  sc.level = $level + 1
				WITH sc,c
				CALL apoc.create.addLabels(sc,['Level' +  ($level + 1) + 'Category']) YIELD node
				MERGE (sc)-[:SUBCAT_OF]->(c)
				WITH DISTINCT c
				SET c.subcatsFetched = true', { level: level }) YIELD value
				RETURN value
			");
			
			
		
		return $categorys;
			
	}
	
	public static function runGraphPages()
	{

		$result = $this->client->run("
			UNWIND range(0,4) as level
			CALL apoc.cypher.doIt('
			MATCH (c:Category { pagesFetched: false, level: $level })
			CALL apoc.load.json(".$this->config['hosturl']."/w/api.php?format=json&action=query&list=categorymembers&cmtype=page&cmtitle=Category:' + apoc.text.urlencode(c.catName) + '&cmprop=ids|title&cmlimit=500')
			YIELD value as results
			UNWIND results.query.categorymembers AS page
			MERGE (p:Page {pageId: page.pageid})
			ON CREATE SET p.pageTitle = page.title, p.pageUrl = "$this->config['hosturl']."/wiki/ + apoc.text.urlencode(replace(page.title, ' ', '_'))
			WITH p,c
			MERGE (p)-[:IN_CATEGORY]->(c)
			WITH DISTINCT c
			SET c.pagesFetched = true', { level: level }) yield value
			return value
		");
	
		return $result;
	}

	
	public static function runGraphPagesWithoutCategory()
	{

		$result = $this->client->run("
			UNWIND range(0,4) as level
			CALL apoc.cypher.doIt('
			MATCH (c:Category { pagesFetched: false, level: $level })
			CALL apoc.load.json(".$this->config['hosturl']."/w/api.php?action=query&format=json&list=allpages&aplimit=max')
			YIELD value as results
			UNWIND results.query.allpages AS page
			MERGE (p:Page {pageId: page.pageid})
			ON CREATE SET p.pageTitle = page.title, p.pageUrl = "$this->config['hosturl']."/wiki/ + apoc.text.urlencode(replace(page.title, ' ', '_'))
			WITH p,c
			MERGE (p)-[:IN_CATEGORY]->(c)
			WITH DISTINCT c
			SET c.pagesFetched = true', { level: level }) yield value
			return value
		");
	
		return $result;
	}
}