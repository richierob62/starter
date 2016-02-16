find_use
Just bring your cursor hover a class name, hit the F5 key (personal shortcut) and that's it.
It will show you the different namespace that match your class, pick up one and your done.
PHP Companion will sort your uses statement in alphabetical order. This can be configured to sort by line length with the use_sort_length user setting.

expand_fqcn
This command expand the class under the cursor to its FQCN (Fully Qualified Class Name). You have two keys for this command F6 and shift+F6 (personal shortcut) that respectively expand without and with the leading namespace separator \.

import_namespace
Just hit the F4 key (personal shortcut), it will add the namespace definition based on the absolute filename of the current file. I use a simple trick to determine where the namespace begun, actually the namespace will start at the first CamelCased folder.
If a namespace is already declared, the command will shout how crazy you are in the status bar.
Warning: This feature require a filename so the command won't work in an unsaved buffer.

goto_definition_scope
Hit shift+F12 (personal shortcut) to search for a method definition based on the current scope. It will fallback to the “goto_definition” command if a match was not found.

insert_php_constructor_property
Hit F7 (personal shortcut) to insert both a constructor argument and its according property. The property will be private by default but you can change it with the visibility setting.

padawan_start_server
This command will start padawan.php server, so that you'll be able to get completions

padawan_stop_server
This command will stop padawan.php server, so that you'll have default sublime completions

padawan_generate_index
This command will generate index for the composer project that current file belongs to. Warning: This command require a filename so the command won't work in an unsaved buffer.

padawan_plugin_add
This command will install(download and register) plugin by it's name. You can find plugins list here Warning: You have to configure composer command for plugin installation

padawan_plugin_remove
This command will remove plugin. Warning: You have to configure composer command for plugin removing