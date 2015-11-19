
The 'uploads' folder is where user, group and map images will be place. 
It also holds the default user profile and group profile images.

Each user who decides to add their own profile image will have a folder created inside the 'uploads' folder
whose folder name will be the unique id number for that user. 
Inside this will be placed their uploaded image and a thumbnail version of their image.

Groups are a spcial kind of user, so for each group created, where an image is added, a folder will be created
inside the 'uploads' folder whose folder name is the unique id number for that group.
Inside this will be placed the group image.

For images added to a Map or a map background, these will be stored inside the folder of the user who created the map, 
inside a sub-folder whose name is the unique id number of the map. 

NOTE: All uploaded images will be transformed to avoid malicious code. 
But, in addition, it is always wise to setup your server NOT to run files with image extensions as if there where php code.
