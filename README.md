# cmp-without-extjs
MODX CMP without ExtJS
based on:
- https://docs.modx.com/revolution/2.x/developing-in-modx/advanced-development/custom-manager-pages/custom-manager-pages-in-2.3
- https://docs.modx.com/revolution/2.x/case-studies-and-tutorials/developing-an-extra-in-modx-revolution


/*---workflow---*/
1. create namespace
- url: domain.com/manager/?a=workspaces/namespace (in manager > top right > cog > namespaces)
- name: customdatabase
- core path: {core_path}components/customdatabase/

2. create menu
- url: domain.com/manager/?a=system/action  (in manager > top right > cog > menus > create menu)
- namespace: customdatabase
- action: my-first-cmp

3. upload core/components/ folder

4. edit schema 
- core/components/customdatabase/model/customdatabase.mysql.schema.xml
- more info at https://docs.modx.com/xpdo/2.x/getting-started/creating-a-model-with-xpdo/defining-a-schema/

5. create snippet from rebuildDatabase.php in manager
- parse schema and create classes
- create tables
- run [[!rebuildDatabase]] uncached on unpublished and uncached page (resource)

6. adjust my-first-cmp.php
- add/remove columns in list view
- add/remove fields to be edited in edit
- change css if needed

7. front-end
- create snippet from productOverview.php
- run in content/template as [[productOverview]]
