**************************
** CUSTOMIZING LANGUAGE **
**************************

The current language system allows you to do two important things:

1. Add another language: You can change the language you are using by translating 
	all the language files into another language.
2. Site specific text: You can change the text in your version of the hub to be site specific.

*****************************
** Adding another language **
*****************************

If you want to add a new language set to the Evidence Hub you need to:

1. Create a new folder inside the 'language' folder whose name the two letter abbreviation 
for the language you are providing a translation for. These codes are specified by the ISO 639 standard 
(http://www.ics.uci.edu/pub/ietf/http/related/iso639.txt), 
e.g.:

Code	Language
----    --------
en	English
fr	French
it	Italian
de	German

2. Copy the language files from inside the default 'en' language folder into you new folder.

3. Inside any given language file, each item is set up as a key/value pair, in the form key='value'.
You must translate/change only the values on the right hand side, NEVER change the key name on the left.

4.Change the language variables in the config file: $CFG->language = 'en'; 
and $CFG->defaultcountry = "United Kingdom"; to reflect your new language of choice.
The $CFG->language setting must match the folder name for your new language.

NB: Some HTML is mixed up in the language files especially in the language heavy areas like 
the About and the Help pages. The languagecore.php file contains the node and link names 
used by other language files. It will always be loaded first so that other language files
can refernece it.

************************
** Site specific text **
************************

To provide site specific text for any of the interface languages you follow this basic pattern:

1. Locate the term you wish to replace in the language files.

2. Create a files with the same name as the file containing the term you wish to change
and place it in the language folder for the relevant domain, either:
1. sites/default/language/<language code>/ for sinlge site use;
2. sites/multi/global/language/<language code>/ for multi sites needed a global changes/additions;
3. sites/multi/<domain folder>language/<language code>/ for multi site domain specific changes/additions.

So, for example, if you wish to replace the ABOUT PAGE in the English language folder, 
create a file as follows depending on sites structure:
1. sites/default/language/en/ for sinlge site ABOUT PAGE replacement;
2. sites/multi/global/language/en/about.php for multi sites needed a global ABOUT PAGE replacement;
3. sites/multi/<domain folder>language/en/about.php for multi site domain ABOUT PAGE replacement.

3. Inside this new file you must use the same key label on the left as in the original file,
and then just replace the part on the right after the '=' sign.
All files in the 'custom' folder are loaded after the ones outside, and provided you have used
the same keys, the text will be replaced with your version when the language files are loaded.

NOTE: If what you want to change any of the core terms, the names of the categories or links,
for example, if you wish to call 'Themes' say 'Topics' instead on your Hub, you can just create a 
custom languagecore.php file and change the text in that. These terms will ripple through the 
rest of the interface text as all the rest of the text should reference those terms through their keys.
This makes it easy to change the basic terminology for a given Hub community without editing lots of interface text.

IMPORTANT: There are two none-standard items in the language folder that are not handled
in the same way as the other language files:

1 The countries.php file: This holds the country names used in the location drop-down menus displayed to users.
When translating these, please, as with the other files change only the part on the right after the '='.
NOTE: this file may need updating if new countries come into existence.
The location of where to check for updates is in the file header.

2. The mailtemplates folder: The files inside this folder are used when constructing the emails send out to users.
When translating them please change only the words and leave all HTML alone, unless you know what you are doing.
Be especially careful about leaving all '%s' items alone.
These are replace with specific text when an email is created.
So the number of '%s' and their order in the file is very important. 
Please don't remove any or that email will no longer be written correctly.
