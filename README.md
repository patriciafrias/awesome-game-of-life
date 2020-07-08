Awesome Game Of Life
========================

This is a project based on [**Symfony 3**][1]. It is an App inspired by the [**Game of Life**][2]
devised by the British mathematician John Horton Conway in 1970.


Technologies
---------------------------------

 * Symfony 3. 
 * [**Vagrant**][3] Box that can be reused to setup the development environment.   
 * [**Ansible**][4] to provision the Vagrant Box. The roles used in this project are provided by[**Geerlingguy**][7] 
 * [**FOS Rest Bundle**][5] to add a Rest Api.  
 * [**PHPUnit**][6] to test each part of the application implementing TDD as much as possible, either Unit and 
   Integration tests.

[1]:  https://symfony.com/doc/3.2
[2]:  https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life
[3]:  https://www.vagrantup.com
[4]:  https://www.ansible.com
[5]:  http://symfony.com/doc/master/bundles/FOSRestBundle
[6]:  https://phpunit.de
[7]:  https://github.com/geerlingguy


Structure
---------------------------------
 
The code is separated in three bundles. 
GameBundle contains Unit and Integration tests.
Test code coverage can be found at var/cache/coverage.
    
**GameBundle**
    This bundle contains all the logic business.                     
           
**ApiBundle**
    With three endpoints to interact with the GameBundle.
        
**ClientBundle**
    Containing the game UI. 
    

How setup this application
---------------------------------
* Install dependencies 
    VirtualBox
    Vagrant
    Ansible

* Install Tic Tac Toe        
    - Copy "vagrant_inventory.example.yml" to "vagrant_inventory.yml" and replace what you need.
    - Check "ansible/hosts" file to make sure that some parameters match with vagrant_inventory.yml.
    - Run "vagrant up"
    - Run "Vagrant ssh" to access to the development box.
    - Run "composer install"
    - Make sure to add a new host in you /etc/hosts (check the IP in your vagrant_inventory)
