# Entry Relationship Field [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/DeuxHuitHuit/entry_relationship_field/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/DeuxHuitHuit/entry_relationship_field/?branch=master)

Version: 1.0.x

> A new way to create master-details (parent-child) relationships with Symphony's sections.

### SPECS ###

- Supports multiple sections for the same relationship.
- Offers developers the possibility to create xslt templates for the field's backend UI.
- Offers a modal UI in order to create/edit for the children.
- Compatible with Symphony associations.
- Supports multiple level (recursive) of associations.
- Aims to be compatible with *all* fields.

#### TODO ####

- Advanced filtering and sorting.


### REQUIREMENTS ###

- Symphony CMS version 2.5.1 and up (as of the day of the last release of this extension)

### INSTALLATION ###

- `git clone` / download and unpack the tarball file
- Put into the extension directory
- Enable/install just like any other extension

You can also install it using the [extension downloader](http://symphonyextensions.com/extensions/extension_downloader/).
Just search for `entry_relationship_field`.

For more information, see <http://getsymphony.com/learn/tasks/view/install-an-extension/>

### HOW TO USE ###

- Go to the section editor and add an Entry Relationship field.
- Give it a name.
- Select at least one section that will be permitted as children.
- Select also the fields you want to be available in the backend templates and data sources.
- Create backend templates in the workspace/er-templates folder.
    - The name of the file must be `section-handle.xsl`
    - You need at least one template that matches `entry`
    - Protip: add `?debug` to backend url to see the available xml for each entry.
    - You can also override the default debug template with `<xsl:template match="/data" mode="debug" priority="1"></xsl:template>`
- (Optional) Select an xsl mode to be able to support multiple templates for the same section.
- (Optional) Select a maximum recursion level for nested fields.
- (Optional) Select a minimum and maximum number of elements for this field.

There is also a [screen cast available](https://www.screenr.com/pDDN)

### AKNOWLEDGMENTS ###

This field would not have been created if some other people did not released some really 
cool stuff. We would like to thanks everybody that contributed to those projects:

- [symphonycms/selectbox_link_field](https://github.com/symphonycms/selectbox_link_field)
- [hananils/subsectionmanager](https://github.com/hananils/subsectionmanager)
- [psychoticmeow/content_field](https://github.com/psychoticmeow/content_field)

We basically trashed things that were not necessary and re-implemented things that we liked
from those extensions.

### LICENSE ###

[MIT](http://deuxhuithuit.mit-license.org)

Made with love in Montréal by [Deux Huit Huit](https://deuxhuithuit.com)

Copyright (c) 2014-2015
