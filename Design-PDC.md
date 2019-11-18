#Design considerations on PDC

This component was designed in line with the recommendations of [Schema.org](https://schema.org) for [Products](https://schema.org/Product) and [Offers](https://schema.org/Offer) and also to the notice by VNG [Gemeentelijk Gegevenslandschap](https://www.gemmaonline.nl/images/gemmaonline/d/dc/GEMMA_Gegevenslandschap_-_PDC_UPL_Zaaktypen_verwerkingsregister_en_adm_handelingen_v1_0.pdf) on, amongst other specifications, Product-and-Service catalogues. Not all variables mentioned in these standards are used, but the entities can be extended to fully implement these specifications.

The goal of this component is to provide a catalogue of products and services for online commerce.

Although we do not wish to make concessions to existing infrastructure we deemed it necessary to divert a little in our design from the version implemented by [Gemeente Buren](https://pdc.buren.nl), as some parts of this API are quite deviant from the standard of Schema.org or are designed in a way we consider undesirable

Properties
----
###Product

In the following table we respond to the properties used in the API by Gemeente Buren with our own decisions with argumentation.

| Property          | Action                                           | Argumentation |
| ----------------- | ------------------------------------------------ | ------------- |
| id                | In use with UUIDs instead of incremental ID      | In Common Ground UUIDs are used for safety issues. |
| title             | In use with the name "name"                      | Adherence to Schema.org |
| slug              | Not used                                         | Assumed to be a property for internal use
| content           | In use with the name "description"               | Adherence to Schema.org|
| excerpt           | Not used                                         | Not in Schema.org standard. If needed the property "slogan" could be added to serve as excerpt |
| date              | Not used                                         | Ambiguous property, would, if needed, be added as "releaseDate"|
| appointment       | In use with the name "requiresAppointment"       | Ambiguous property name. This property is for products that require physical appointments, for example to request travel documents or for the booking of hotel rooms |
| downloads         | Implemented as "documents"                       | We decided to use the common ground "documenten" component |
| faq               | Not implemented at this time                     | In our opinion faqs should be implemented with a separate component |
| forms             | Not implemented                                  | Is not a property that should be in a PDC, has more to do with the VerzoekTypenCatalogus component |
| image             | Implemented as "images", referring to the DRC    | Design choice |
| links             | Implemented as "externalDocs"                    | Conform OAS |
| locations         | Not implemented                                  |  |
| synonyms          | Not implemented                                  | The use of this property is ambiguous, looking at the use it might be better to replace this property by a ManyToMany relationship to an entity "tags" |
| pdc-doelgroep     | Implemented as "eligibleCustomerType" in "Offer" | Adherence to Schema.org |
| pdc-type          | Implemented as "type"                            |  |
| pdc-aspect        | Not implemented                                  |  |
| pdc-usage         | Not implemented                                  | Comparable to GEMMA-channels but product should be channel-independent |
| pdc-owner         | Implemented as "sourceOrganisation"              |  |
| title_alternative | Not implemented                                  | If needed, we propose to implement this property as "alternateName" to keep adherence to Schema.org standards |

Additionally we implemented the following properties

| Property          | Function                                               | Argumentation |
| ----------------- | ------------------------------------------------------ | ------------- |
| sku               | Human-readable product reference                       | Because of the use of UUIDs it is vital to also have a human-readable reference for the product. Schema.org recommends the property "sku" or stock-keeping unit to do this |
| skuId             | Auto-incrementing id part of "sku"                     | - |
| movie             | Adding a movie to the product                          | Some products sell better when a video is added |
| groups            | Specifying product groups                              | - |
| price             | The price of the product                               | This PDC can also be used outside of municipalities, and hence, products can have a price |
| priceCurrency     | The currency the price is in                           | When we set a price, it is theoretically possible that this price is in a different currency, hence a property to set this |
| taxPercentage     | The tax percentage that is calculated over the product | There can be multiple levels of tax that are calculated over the price of a product (e.g. 9% or 21% in the Netherlands), this can be set with this property |
| parent            | A parent product for complex products                  | Some products are complex having child-products (variations) or parent-products, this property refers to a parent product |
| variations        | The variations of a complex product                    | See above, this property refers to child products |
| groupedProducts   | Products that are part of a set                        | When the product type is a "set", this property contains the products that are in the set |
| sets              | Sets that the product is part of                       | See above, this property refers to the set the product is part of |
| catalogue         | The catalogue the product belongs to                   | A product belongs to a specified catalogue, referred to by this property |
| offers            | The offers that are used to sell this product          | The price of a product can vary over time. To prevent old orders from being corrupted by a changing price, we use offers that have a fixed price and are replaced once the price has to change. |
| calendar          | The calendar of a product                              | Some types of products, for example hotel rooms or wedding locations can be in use because of other orders. The calendar shows when this product is available |

###Offer
TODO

Contribute
----
Do you have questions, ideas or do you want to contribute in another way? Check [CONTRIBUTING.md](https://github.com/ConductionNL/productenendienstencatalogus/blob/master/.github/CONTRIBUTING.md) and start contributing!
