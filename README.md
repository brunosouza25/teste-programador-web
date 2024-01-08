Projeto desenvolvido com o framework Symfony 6.4, PHP 8.2, MySQL, Boostrap 5, Jquery, HTML5 e CSS3.
Também foi utilizado alguns plugins como o datatable e jconfirm.

Pode se rodar o comando "php bin/console doctrine:migrations:migrate" para rodar as migrations e ter uma base de dados limpa ou se preferir existe um arquivo chamado dump.sql que está localizado na pasta raiz contendo um banco de dados já preenchido
Também rodar o comando "composer install" para a instalação dos pacotes do Symfony
Nome do banco de dados: imply
Usuario: root
Senha:
Qualquer informação sobre a base de dados está no arquivo .env na raiz do projeto

O projeto em si foi seguido uma arquitetura MVC baseada em Controller, Service e Repository, a mesma não foi feita de forma complexa visando a facilidade de utilização e para outras pessoas que irão analisar ou estudar o código
