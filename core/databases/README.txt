
/** THE DATABASE LAYER **/

All sql statements have been extracted from the code and place in files inside the 'base' folder. 
This was done in order to make adding a new database type easier.
Currently the sql statements in the 'base' folder are written for MySQL.

sqlstatements.php loads all the sql statment variables into $HUB_SQL class/variable collection. It always loads
the files in the 'base' folder first and then any overrides from any other folder sepcificed $CFG->databasetype
but at present there are no other supported database types.

The databasemanager.class.php file manages accessing the database.
Inside there you will see that we have two database types setup; 'mysql' and 'odbc'.
We did experiment with using Virtuoso through the 'odbc' connection functions in the manager. 
But we untimately decided against it. So at present 'odbc' is there, but not really working.
However we left the function in the manager so other people could choose to use/modify them.

If you wanted to use an odbc database, you would need to create a folder at the same level as the 'base' folder.
You could call it 'odbc', but I would be more specific than that. So, for example, we had a folder called 'virtuoso'
in our testing. Into that new folder you would put any sql overrides that where required by that database type making sure
the file names and variables names where the same as in the base files you where overriding. But you only need to include
those files and variables you want to override. You would need the folder name to be one word and lower case.

You then need to add the new type (your folder name) to the databasemanager.class.php as a new $DATABASE_TYPE_ declaration
Also in the databasemanager.class.php file you would need to edit the 'createConnection', 'select', 'insert' and 'delete' functions
to add your new type in. This new name would then be what you also set in the $CFG->databasetype variable in the domain config file
to get the website to use your new database type.

This is all still a bit experimental, but we did test successfully with Virtuoso as a second choice of database type and where
able to switch between mysql and virtuoso just by chaning the $CFG->databasetype variable.
In the end, Virtuoso didn't really handle long text types well and we had various other issues with sql statements,
so we took it out as a second option as we didn't have the time to really fully debug it. 
Some places in the code you may still see odd database calls where it says
that this was done for Virtuoso. At some point in the future they may be cleaned out.

'databaseutility.php' has many functions for calling the database to get data for odd bits and pieces.
Hoewever the main place to look is 'core/datamodel' where the datamodel classes load and manage their data.
For each class in the 'core/datamodel' folder there should be a file in the 'core/databases/base' folder with
that classes sql statements. There are then additional files in the 'base' folder for other code files that
call the database like 'core/apilib.php', 'core/auditlib.php', 'core/statslib.php' and 'core/databases/databaseutillib.php'