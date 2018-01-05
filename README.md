# Symfony 3.4 web application for a thesaurus
Created with PHP 7.0 and MySQL 5.6.28

# Requirements : 
The project has to be created and launched on a computer with apache/mysql running.

# Install the application
1- Clone the Git project with the command :
git clone https://github.com/SLmathieu/SL_Thesaurus.git
2- Update the file app/config/parameters.yml with your mysql user/password
3- Create the database with these 2 commands :
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
4- That's all !

# Commands : 

php bin/console sl:thesaurus:getwords
=> Display all the words that are stored in the thesaurus

php bin/console sl:thesaurus:addsynonyms
Adds the given words as synonyms to each other

php bin/console sl:thesaurus:getsynonyms
Display all the synonyms for a word
