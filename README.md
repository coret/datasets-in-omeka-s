# datasets-in-omeka-s
Howto and code to manage datasetdescriptions in Omeka-S.

Configuration

This howto provides the means to manages dataset descriptions as specified in https://netwerk-digitaal-erfgoed.github.io/requirements-datasets/#organization-overview

Two propertie of a dataset are based on a custom vocabulairy (this requires the Custom vocabs model [https://omeka.org/s/modules/CustomVocab/])
- Licenses
- Media types

The resource templates necessary for managing datasets are:
- Datacatalog
- Datasets
- Distribution
- Organization

Data entry

Because the resources are linked as Omeka items, the order of data entry is bottom-up. So first add the organization which are to be used in the dataset(s).# Managing datasets in Omeka-S

A howto and code to manage and publish datasetdescriptions in Omeka-S. It is the description of the implementation for [datasets for the Gouda Timemachine](https://www.goudatijdmachine.nl/data/datasets/start).

## Configuration

This howto provides the means to manages dataset descriptions as specified in https://netwerk-digitaal-erfgoed.github.io/requirements-datasets/#organization-overview

Some properties of a dataset are based on a [custom vocabulairy](custom%20vocabs/) which requires the [Custom vocabs](https://omeka.org/s/modules/CustomVocab/) module:
- [Licenses](custom%20vocabs/Licenses.txt)
- [Media types](custom%20vocabs/Media%20types.txt)
- 
The [resource templates](resource%20templates/) necessary for managing datasets are:
- [Datacatalog](resource%20templates/Datacatalog.json)
- [Datasets](resource%20templates/Datasets.json)
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

To make a datadump of the data catalog, including all datasets, distributions and organizations, a simple crawler is provided. This PHP based crawler uses the Omeka-S API. Besides fetching all sub-resources, all Omeka-S properties and classes are removed. 

## Publishing
The datadump is store in the files directory of Omeka-S which makes the file available for download.

datadump 
transformatie


## Findability
A way to make the dataset description findable is to make use of the [Well-Known Path Prefix](https://datatracker.ietf.org/doc/html/rfc5785) /.well-known/datacatalog

This can be configured on webserver level (see [Apache example](apache-well-known-datacatalog.conf) for Gouda Timemachine), including conten-negotiation. The result is a redirect in your webbrowser from [/.well-known/datacatalog](/data/datasets/document/ark:/60537/b0POu1) to the Item page of the data catalog.

When providing an Accept header, a Turtle, N-Triples, JSON-LD of RDF/XML can be retrieved. Example:

    curl -L -H "Accept: text/turtle" https://www.goudatijdmachine.nl/.well-known/datacatalog
        
## What's missing
- Omeka-S item HTML page with a complete dataset description (in JSON-LD script block).
- Use of organizational URI strategy, currently only "API URIs".
Then per dataset, make entries for the distribution. 
Next, the datasets can be described, linking them to distributions (Items) and organizations (Items).
Finally, a data catalog can be made, this includes links to all datasets (Items).

Datadump

alle resource templates exporteren (datacatalog, dataset, datadownload, organisatie) 

datadump 
transformatie

howto curl catalog 

dublin core omeka-s sharon

content-negotiation
