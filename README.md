# php-mysql-to-mysqli

This is a simple class for easy migrate from you php mysql to mysqli driver for very old scripts.

# How to use: 
1. include file into your project
2. Set default config DB::setConfig(assoc array of mysql connect data), example into the code
3. Replace all mysql_* functions from your code to DB::mysql_* metods
4. That's all folks
