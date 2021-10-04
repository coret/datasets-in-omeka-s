<?php

require 'vendor/autoload.php';

# Configuration

# URL of the API retrieve call to the data catalog
$baseUrlDataCatalogViaApi="https://www.goudatijdmachine.nl/data/api/items/12997";

# Director where to output the datadump files
$baseDirectoryOmekaFiles=".";

# Step 0 - create graph and define prefix schema:

\EasyRdf\RdfNamespace::set('schema', 'https://schema.org/');

$graph = new \EasyRdf\Graph();

# Step 1 - get data catalog

$graph->parse($baseUrlDataCatalogViaApi, 'jsonld');

foreach($graph->resources() as $resource) {

	# Step 2 - get all datasets which are part of the data catalog

	$datasets=$resource->allResources("schema:dataset");
	foreach ($datasets as $dataset) {
		$dataset_uri=$dataset->getUri();
		$graph->parse($dataset_uri, 'jsonld');
	}

	# Step 3 - get all distribution which are part of datasets

	$distributions=$resource->allResources("schema:distribution");

	foreach ($distributions as $distribution) {
		$distribution_uri=$distribution->getUri();
		$graph->parse($distribution_uri, 'jsonld');
	}

	# Step 4 - get all publishers and creators (of data catalog and datasets)

	$publishers=$resource->allResources("schema:publisher");

	foreach ($publishers as $publisher) {
		$publisher_uri=$publisher->getUri();
		$graph->parse($publisher_uri, 'jsonld');
	}

	$creators=$resource->allResources("schema:creator");

	foreach ($creators as $creator) {
		$creator_uri=$creator->getUri();
		$graph->parse($creator_uri, 'jsonld');
	}
}

# Step 5 - remove Omeka classes and properties (o:)

foreach($graph->resources() as $resource) {
	foreach($resource->properties() as $pu) {
		if ($pu=="rdf:type") {
			foreach ($resource->all("rdf:type") as $s) { 
				if (preg_match("/omeka\.org\/s\/vocabs\/o/",$s)) {
					$resource->delete("rdf:type",$s);
				}				
			}
		}
	}
	foreach($resource->propertyUris() as $pu) {
		if (preg_match("/omeka\.org\/s\/vocabs\/o/",$pu)) {
			$resource->delete($pu);
		}
	}
}

# Step 6 - output the graph in several serializations

$serializations=array("turtle"=>"ttl","ntriples"=>"nt","jsonld"=>"jsonld","rdfxml"=>"xml");
foreach ($serializations as $serialization=>$extension) {
	$serialization_contents = $graph->serialise($serialization);
	file_put_contents($baseDirectoryOmekaFiles."/datacatalog.".$extension,$serialization_contents);
}