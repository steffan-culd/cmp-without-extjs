# cmp-without-extjs
MODX CMP without ExtJS

/*---workflow---*/
1. create namespace
- url: domain.com/manager/?a=workspaces/namespace
- name: customdatabase
- core path: {core_path}components/customdatabase/

2. create menu
- url: domain.com/manager/?a=system/action (create menu)
- namespace: customdatabase
- action: my-first-cmp

3. upload core/components/ folder

4. edit schema (https://docs.modx.com/xpdo/2.x/getting-started/creating-a-model-with-xpdo/defining-a-schema/)

5. create snippet from rebuildDatabase.php
- parse schema and create classes
- create tables
- execute uncached on unpublished and uncached page (resource)

6. adjust my-first-cmp.php
- add/remove columns in list view
- add/remove fields to be edited in edit
- change css if needed
