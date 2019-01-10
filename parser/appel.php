<html>
<body>
<?php
 
include ('XmlParser.php');
         
// $parser = new XmlParserExample1(dirname(__FILE__).'/rss.xml');
// $parser = new XmlParserExample1('https://www.engadget.com/rss.xml');
$parser = new XmlParser('https://www.cnet.com/rss/news/', "cnet");
$parser ->parse();
$result = $parser ->getResult();
echo $result;
// var_dump($result);
 
?>
</body>
</html>
