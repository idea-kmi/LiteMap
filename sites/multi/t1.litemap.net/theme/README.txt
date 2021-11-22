
IMPORTANT NOTE: Always leave the 'default' theme in the main directory alone. Never edit or delete it.
It is the fallback location for all style sheets, interface images, etc..
so the Evidence Hub will not work correctly without it.

CREATING A NEW THEME

To create a new theme:
1. Create a folder with your new theme name inside this 'theme' folder.
2. Add/Change the config setting $CFG->uitheme and set it to the name of you new theme folder.

3. Override the 'default' theme:

   STYLESHEETS
   To override stylesheets, create a 'styles' subfolder inside your new theme folder.
   Copy into the styles folder the stylesheet from the 'default' style that you wish to modify.
   Make you modifications.

   IMAGES
   To override images, create an 'images' subfolder inside your new theme folder.
   Create the new image that you wish to use instead of the default.
   Make sure the new image type and name matches exactly the image type and name for 
   the image you wish to replace.
   
   Help images are usually inside 'help/images/' but for the purposes over replacing
   a help image put them in the theme 'images' subfolder as other images.
   
   If you look inside the theme 'default/images' you will see the basic set of images you will 
   probably wish to replace, like the header logo, and depending on your colour scheme, some buttons.
   
   The following images cannot currently be overridden using the themes system 
   due to the way they are referenced in the code:
   
   images/conn-negative-slim3.png
   images/conn-positive-slim3.png
   images/conn-neutral-slim3.png
   
   (used by /ui/popups/showmulticonns.php + admin/userContextStats.php)

   images/blank.png
   
   (used by ui/popups/printorggeomap.html + printusergeomap.html + printusernodegeomap.html);