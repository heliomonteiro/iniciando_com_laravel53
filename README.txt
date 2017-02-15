-----------
.gitignore
-----------
/node_modules
/public/storage
/vendor
/.idea
Homestead.json
Homestead.yaml
.env

----------------------------
Acessar variável global .env
----------------------------
-> $_ENV['MINHA_CHAVE]
-> getenv('MINHA_CHAVE)
OBs.: Sempre que mudar configuração no .ENV, reiniciar o servidor.

----------------------
Ambientes de trabalho
----------------------
-.ENV
APP_ENV=local (modo desenvolvimento) - Modo muito lento. Não utilizar no servidor, para não gerar muito cache.)
APP_ENV=prod (modo de produção) - utilizado no servidor)
APP_DEBUG=true (modo de debug) - utilizado em desenvolvimento - apresenta erros completos reportados pela aplicação)

-CONSOLE
php artisan down (coloca em modo de manutenção)
php artisan up (retorna do modo de manutenção)

Ambiente 			Variável 	Configuração
Produção 			APP_ENV 	prod
Produção 			APP_DEBUG 	false
Desenvolvimento 	APP_ENV 	local
Desenvolvimento 	APP_DEBUG 	true

----------------------------