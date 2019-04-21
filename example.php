<!DOCTYPE HTML>
<html>
<head> 
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<title>Apriori Alghoritm</title>
</head>
<body style="font-family: monospace;">
<?php   
include 'class.apriori.php';
include 'connect.php';
$Apriori = new Apriori();
$fre = array();
error_reporting(E_ALL ^ E_WARNING); 

$Apriori->setMaxScan(20);       //Scan 2, 3, ...
$Apriori->setMinSup(2);         //Minimum support 1, 2, 3, ...
$Apriori->setMinConf(75);       //Minimum confidence - Percent 1, 2, ..., 100
$Apriori->setDelimiter(',');    //Delimiter 
$sql = "SELECT * FROM test";
$sqlrun = mysqli_query($conn, $sql);
$names1 = array();
while($row = mysqli_fetch_array($sqlrun))
{
    $names1[] = $row['products'];
    //print_r $names bag kay yete
    //fakt $row cha output bag kay ahe
    //$row[0] then 1 check kar and bag
    //quey php my admin chya command line war fire karun bag
    //ek min thamb ha
}
print_r($names1);
/*Use Array:
$dataset   = array();
$dataset[] = array('A', 'B', 'C', 'D'); //row1
$dataset[] = array('A', 'D', 'C');  //row 2
$dataset[] = array('B', 'C'); 
$dataset[] = array('A', 'E', 'C'); */
$Apriori->process($names1);
//$Apriori->process('dataset.txt');

//Frequent Itemsets
//echo '<h1>Frequent Itemsets</h1>';
//$Apriori->printFreqItemsets();
//print_r($Apriori->printFreqItemsets());

echo '<h3>Frequent Itemsets Array</h3>';
$result = array();
$result = $Apriori->getFreqItemsets();
echo $result[0]." and ".$result[1]


//Association Rules
//echo '<h1>Association Rules</h1>';
//$Apriori->printAssociationRules();

/*echo '<h3>Association Rules Array</h3>';
print_r($Apriori->getAssociationRules()); 

//Save to file
$Apriori->saveFreqItemsets('freqItemsets.txt');
$Apriori->saveAssociationRules('associationRules.txt');*/
?>  
</body>
</html>
