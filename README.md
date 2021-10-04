# Managing datasets in Omeka-S

This howto provides the means to manage dataset descriptions in [Omeka-S](https://omeka.org/s/) as specified in [Requirements for datasets](https://netwerk-digitaal-erfgoed.github.io/requirements-datasets/). It's also the description of the implementation for [datasets for the Gouda Timemachine](https://www.goudatijdmachine.nl/data/datasets/start).

## Configuration

Some properties of a dataset are based on a [custom vocabulairy](custom%20vocabs/) which requires the [Custom vocabs](https://omeka.org/s/modules/CustomVocab/) module:
- [Licenses](custom%20vocabs/Licenses.txt)
- [Media types](custom%20vocabs/Media%20types.txt)

The [resource templates](resource%20templates/) necessary for managing datasets are:
- [Datacatalog](resource%20templates/Datacatalog.json)
- [Dataset](resource%20templates/Dataset.json)
- [Distribution](resource%20templates/Distribution.json)
- [Organization](resource%20templates/Organization.json)

## Data entry

Because the resources are linked as Omeka items, the order of data entry is bottom-up. 

 1. So first add the organization which are to be used in the
    dataset(s). 
 2. Then per dataset, make entries for the distribution.
 3. Next, the datasets can be described, linking them to distributions
    (Items) and organizations (Items).
 4. Finally, a data catalog can be made, this includes links to all
    datasets (Items).

## Datadump

To make a datadump of the data catalog, including all datasets, distributions and organizations, a simple crawler is provided. This PHP based [crawler](src/datadump.php) uses the [EasyRDF](https://www.easyrdf.org/) to collect all resources via the Omeka-S API. Besides fetching all (sub-)resources, all Omeka-S properties and classes are removed. 

## Publishing
The datadumps (in Turtle, N-Triples, JSON-LD and RDF/XML) are store in the files directory of Omeka-S which makes the file available for download.

## Findability
A way to make the dataset description findable is to make use of the [Well-Known Path Prefix](https://datatracker.ietf.org/doc/html/rfc5785) /.well-known/datacatalog

This can be configured on webserver level (see [Apache example](apache-well-known-datacatalog.conf) for Gouda Timemachine), including conten-negotiation. The result is a redirect in your webbrowser from [/.well-known/datacatalog](https://www.goudatijdmachine.nl/.well-known/datacatalog) to the Item page of the data catalog.

When providing an Accept header, a Turtle, N-Triples, JSON-LD or RDF/XML can be retrieved. Example:

    curl -L -H "Accept: text/turtle" https://www.goudatijdmachine.nl/.well-known/datacatalog
        
## What's missing
- Omeka-S item HTML page with a complete dataset description (in JSON-LD script block), instead of the default Omeka-S "shallow" version (no sub-resources).
- Use of organizational URI strategy/clean URL module, currently only "Omeka-S API URIs".