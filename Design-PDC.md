#Design considerations on PDC

This component was designed in line with the recommendations of [Schema.org](https://schema.org) for [Products](https://schema.org/Product) and [Offers](https://schema.org/Offer) and also to the notice by VNG [Gemeentelijk Gegevenslandschap](https://www.gemmaonline.nl/images/gemmaonline/d/dc/GEMMA_Gegevenslandschap_-_PDC_UPL_Zaaktypen_verwerkingsregister_en_adm_handelingen_v1_0.pdf) on, amongst other specifications, Product-and-Service catalogues. Not all variables mentioned in these standards are used, but the entities can be extended to fully implement these specifications.

The goal of this component is to provide a catalogue of products and services for online commerce.

Although we do not wish to make concessions to existing infrastructure we deemed it necessary to divert a little in our design from the version implemented by [Gemeente Buren](https://pdc.buren.nl), as some parts of this API are quite deviant from the standard of Schema.org or are designed in a way we consider undesirable

Properties
----
###Product

In the following table we respond to the properties used in the API by Gemeente Buren with our own decisions with argumentation.

| Property        | Action         | Argumentation |
| --------------- | -------------- | ------------- |
| id              | In use with UUIDs instead of incremental ID | In Common Ground UUIDs are used for safety issues. |
| title           | In use with the name "name" | Adherence to Schema.org |
| slug            | Not used       | Assumed to be a property for internal use
| content         | In use with the name "description" | Adherence to Schema.org|
| excerpt         | Not used       | Not in Schema.org standard. If needed the property "slogan" could be added to serve as excerpt |
| date            | Not used       | Ambiguous property, would, if needed, be added as "releaseDate"|
| appointment     | In use with the name "requiresAppointment" | Ambiguous property name. This property is for products that require physical appointments, for example to request travel documents or for the booking of hotel rooms |
| downloads       | Implemented as "documents" | We decided to use the common ground "documenten" component |
| faq             | Not implemented at this time | In our opinion faqs should be implemented with a separate component |

###Offer
