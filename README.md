# CodeIgniter Rest Server With JWT Authentication

A fully RESTful server implementation for CodeIgniter using JWT for Authentication
## Notes

- Required php ^7.4 || ^8.0
- Import Database from /db/rest_jwt.db
- Test it with postman/insomnia
- Start Development Process with ```$ php spark serve```
- Create post method from postman for user authentication "http://localhost:8080/api/auth/login"
- Add this to body multipart form :
	
	username = dodi
	
	password = dodi123
- If your authentication success you will get generated token response
- To test it, go Create post method from postman "http://localhost:8080/api/main/test" and then you can attach that generated token you've got to the header authentication bearer token. see example bellow :

	Authentication: Bearer "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjIiLCJ1c2VybmFtZSI6ImRvZGk"

## For Laragon User (Windows)

- Please enable extension_dir to your PHP Path Extenstion -> https://stackoverflow.com/a/1808475
- Enable some extenstion, **curl,intl,mbstring,mysqli,openssl**
- Enable **openssl.cafile** with File at here -> https://curl.se/docs/caextract.html
- Run ```composer update```

## Refference

This project Using REST by Phil Sturgeon and Firebase/PHP-JWT.
For more information :
## REST
https://github.com/chriskacerguis/codeigniter-restserver
## JWT
https://github.com/firebase/php-jwt
