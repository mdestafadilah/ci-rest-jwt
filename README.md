# CodeIgniter Rest Server With JWT Authentication

A fully RESTful server implementation for CodeIgniter 4 using JWT for Authentication
## Notes

- Required php ^7.4 || ^8.0
- Import Database from /db/rest_jwt.db
- Test it with postman/insomnia
- Start Development Process with ```$ php spark serve```
- Create post method from postman for user authentication "http://localhost:8080/auth/register"
- Add this to body multipart/ form-data form (for example only):
	
	> username = desta
	>
	> password = topidesta
	>
	> email = desta@rsuppersahabatan.co.id

- Create .env file with Secret Key

```json
#JWT_SECRET_KEY key is the secret key used by the application to sign JWTS. Pick a stronger one for production.
JWT_SECRET_KEY=kzUf4sxss4AeG5uHkNZAqT1Nyi1zVfpz 
#JWT_TIME_TO_LIVE indicates the validity period of a signed JWT (in milliseconds)
JWT_TIME_TO_LIVE=3600
```

- If your authentication success you will get generated token response

```json
{
    "message": "Authentikasi user Berhasil!",
    "users": {
        "id": "7",
        "username": "fadilah",
        "level": "0",
        "email": "desta@rsuppersahabatan.co.id",
        "updated_at": null,
        "created_at": "2021-12-28 11:51:17"
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImRlc3RhQHJzdXBwZXJzYWhhYmF0YW4uY28uaWQiLCJpYXQiOjE2NDA2NjcwNzYsImV4cCI6MTY0MDY2NzA3Nn0.d-CNLV43q7wyIlxi32Hs9hbodPHJe_55P6Z_DBPfsRA"
}
```

- To test it, go Create post method from postman "http://localhost:8080/api/main/test" and then you can attach that generated token you've got to the header authentication bearer token. see example bellow :

	Authentication: Bearer "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjIiLCJ1c2VybmFtZSI6ImRvZGk"

## For Laragon User (Windows)

- Please enable extension_dir to your PHP Path Extenstion -> https://stackoverflow.com/a/1808475
- Enable some extenstion, **curl,intl,mbstring,mysqli,openssl**
- Enable **openssl.cafile** with File at here -> https://curl.se/docs/caextract.html
- Run ```composer update```

## Limitation of Application

This App is just for my Fun learning Codeigniter 4. If you need more advance with more secure feature of Codeigniter 4 power, follow this code below, i'm sure you will be more exited.

> https://github.com/gunantos/ci4restfull-starter

## Refference

This project Using REST by Phil Sturgeon and Firebase/PHP-JWT.
For more information :
## REST
https://github.com/chriskacerguis/codeigniter-restserver
## JWT
https://github.com/firebase/php-jwt
