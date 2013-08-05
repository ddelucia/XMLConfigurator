XMLConfigurator
===============

Single class to load a config.xml file and access the value through a method.
If the requested xml attribut exists, the value will be returned. If it doesn't exist an Exception is thrown.

How to use
==========

1. Make sure you have access to the file XMLConfigHandler.php
(Namespace: \XMLConfig\lib\XMLConfigHandler)

2. Your config.xml file have to be in the same folder as the XMLConfigHandler. No panic, if you have it
   in the root folder of the project it works also correctly. 

3. Use it :-) 

Example:

Let's say you have a config entry with the attribut name projectname.

$projectname = XMLConfigHandler::value('projectname');

That's it.

Keep it simple! 
