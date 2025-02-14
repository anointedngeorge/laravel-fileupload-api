# File Upload API with AWS S3

## Requirements

Run the following command to install the required package:

```sh
composer require league/flysystem-aws-s3-v3


AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

php artisan install:api
php artisan migrate

API Routes
Authentication

    POST → {url}/api/auth/register - Register a new user
    POST → {url}/api/auth/login - Login an existing user

File Upload Routes

    POST → {url}/api/upload - Upload a file (Params: file, caption)
    PUT → {url}/api/upload/{id} - Update a file (Params: file (optional), caption)
    GET → {url}/api/upload - Fetch all uploaded files
    DELETE → {url}/api/upload/{id} - Delete a file

```

```

```
