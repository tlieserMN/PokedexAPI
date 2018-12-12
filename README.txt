This is a web API written in php using the Laravel framework.

The web API uses basic authentication with OAuth 2 authorization using Laravel Passport.

Routes:
POST /api/capture captures a specific pokemon.
GET /api/captured returns all captured pokemon.
GET /api/pokemon/{id?} returns one or all pokemon.
POST /api/updatepokemon updates pokemon.
POST /api/createpokemon creates a new pokemon.
POST /api/deletepokemon deletes one pokemon.

How to use:
Trainers must register with the API.
Passport must create a client_id and client_secret for that trainer.

Use Postman desktop application to send requests to API.
Create new oauth2 authorization type with
	Auth URL: /oauth/authorize?
	Access Token URL: /oauth/token?
and the remaining information.
Copy the access token given and change the authroization type to Bearer Token and 
paste in the access token.
Then start creating requests

Database structure:
default tables Laravel gives you:
	migrations
	oauth_access_tokens
	oauth_auth_codes
	oauth_clients
	oauth_personal_access_clients
	oauth_refresh_tokens
	password_resets
	users
created tables:
	pokemon: holds pokemon information
		id int not null auto_increment primary key
		names vavrchar(65535)
		types longtext
		height int
		weight int
		abilities longtext
		egg_groups longtext
		stats longtext
		genus varchar(65535)
		description varchar(65535)
	trainercapture: pokemon that get captured for each trainer
		trainer_id int primary key
		pokemon_id int primary key
