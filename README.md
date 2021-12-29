<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## DOCUMENTAÇÃO DA APLICAÇÃO

### EXECUTE NO SEU TERMINAL OS SEGUINTES COMANDOS

- git clone https://github.com/rnads/my-system-labs
- cd my-system-labs
- composer install
- cp .env.example .env
- php artisan key:generate

No seu localhost, crie um novo banco de dados com o nome "laravel"

Obs.: caso tenha senha, edite o .env nos campos abaixo:<br>
DB_USERNAME=NULL<br>
DB_PASSWORD=NULL<br>

Edite o arquivo .env nos seguintes campos, para o envio de e-mail:

MAIL_MAILER=smtp <br>
MAIL_HOST=mailhog<br>
MAIL_PORT=1025<br>
MAIL_USERNAME=null<br>
MAIL_PASSWORD=null<br>
MAIL_ENCRYPTION=null<br>
MAIL_FROM_ADDRESS=null<br>
MAIL_FROM_NAME="${APP_NAME}"<BR>
QUEUE_CONNECTION=database<br>

Obs.: Site recomendado para testes grátis de envio: [mailtrap](https://mailtrap.io/)

Retorne ao terminal, e execute:<br>
- php artisan migrate --seed
- php artisan serve

Usuário padrão criado.<br>
Usuário: admin@admin.com <br>
Senha: admin

Obs: Após a criação de um novo estudante ou professor, a senha padrão é 123456;
O envio dos e-mails de notificação ao estudante inscrito após o cancelamento da aula estão indo para fila, necessário executar no terminal o comando abaixo:
php artisan queue:work



