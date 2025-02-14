Requirements
composer require league/flysystem-aws-s3-v3

<h4>Setup Aws Bucket 3 credentials</h4>
>>> AWS_ACCESS_KEY_ID=
>>> AWS_SECRET_ACCESS_KEY=
>>> AWS_DEFAULT_REGION=us-east-1
>>> AWS_BUCKET=
>>> AWS_USE_PATH_STYLE_ENDPOINT=false

<h4>Required Artisan Commands</h4>

> > > php artisan install:api
> > > php artisan migrate

<h4>API ROUTES</h4>

> > > <p>Authentication</p> <<<<
> > > POST -> {url}/api/auth/register
> > > POST -> {url}/api/auth/login

> > > <p>File Upload Url</p> <<<<
> > > POST -> {url}/api/upload [Params: [file, caption] ]
> > > PUT -> {url}/api/upload/$id [Params: [file(optional), caption] ]
> > > GET -> {url}/api/upload Fetch all uploads
> > > DELETE -> {url}/api/upload/$id
