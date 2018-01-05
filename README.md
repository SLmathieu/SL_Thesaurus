# Symfony 3.4 web application for a thesaurus
Created with PHP 7.0 and MySQL 5.6.28.
Also tested with success with php 5.6.27

# Requirements : 
The project has to be created and launched on a computer with apache/mysql running.

# Install the application

1- Clone the Git project with the command :
git clone https://github.com/SLmathieu/SL_Thesaurus.git

2- Update the file app/config/parameters.yml with your mysql user/password/port

3- Create the database with these 2 commands :
php bin/console doctrine:database:create
=> result expected : Created database `SL_Thesaurus_MB` for connection named default
php bin/console doctrine:schema:update --force
=> result expected : Database schema updated successfully! "2" queries were executed

4- That's all !

# Commands : 

 * php bin/console sl:thesaurus:getwords
=> Display all the words that are stored in the thesaurus

 * php bin/console sl:thesaurus:addsynonyms
Adds the given words as synonyms to each other.
The synonyms are written in txt files, stored in web/uploads/synonyms_files.
Each line specifies a list of synonyms. The synonyms are separated with a comma.
You can check the 2 examples synonyms1.txt and synonyms2.txt
There is no limit of words per line or lines or files per directory.

 * php bin/console sl:thesaurus:getsynonyms XXXX
Display all the synonyms for a word specified (instead of XXXX :))
Example of word in the dataset : jobba, accomplished, manger

In case of trouble, please contact mathieu.blanchet@gmail.com

Mathieu.
