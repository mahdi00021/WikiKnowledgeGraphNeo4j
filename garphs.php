<?php

?>
<?php
namespace ClientCode;

?>
<html>
<head>
    <title>DataViz</title>
    <style type="text/css">
        #viz {
            width: 900px;
            height: 700px;
        }
    </style>
    <script src="https://rawgit.com/neo4j-contrib/neovis.js/master/dist/neovis.js"></script>
</head>
<script>
    function draw() {
        var config = {
            container_id: "viz",
            server_url: "bolt://52.165.240.119:7687",
            server_user: "neo4j",
            server_password: "addition-hillskl;ides-balk;",
            labels: {
                "Category": {
                    caption: "user_key",
                    size: "pagerank",
                    community: "community"
                }
            },
            relationships: {
                "Category": {
                    caption: true,
                    thickness: "count"
                }
            },
            initial_cypher: "MATCH p=()-[r:SUBCAT_OF]->() RETURN p LIMIT 25"
        }

        var viz = new NeoVis.default(config);
        viz.render();
    }
</script>
<body onload="draw()">
<div id="viz"></div>
</body>
</html>