# RESTful API BileMo
===============

An API provided by a mobile phone manufacturer for businesses.
The API allow users/clients to access BileMo's mobile phone catalog.
A Symfony 3.4 Project.
[Try the project without installing it here (via the API documentation)](http://bilemo.ffouillet.fr/api/doc)

## Installation
1.  Clone (or download) the repository on your local machine. Run this command to clone the repository :  ```git clone https://github.com/ffouillet/RESTful_API_BileMo.git ```  
2.  Install project dependencies by running following command in the project directory : ```composer install``` . It will ask you for parameters (which are registered in parameters.yml.dist), leaves at default or set your own.  
3.  Create the database and update the database schema by running following commands (always in the project directory) :   
```php bin/console doctrine:database:create```  
```php bin/console doctrine:schema:create```  
```php bin/console assets:install --symlink```    
4.  Your project is ready, open your client/browser and go to the server url pointing to your project.  

## Running the installed project  

### Adding Test datas
You can add a Demo User and some BileMo's Mobile Phones to test the project.
Run the following command in the project directory to add 1 User (username : demoUser, password : demoPassword), 30 BileMo's Mobile phones :  
``` php bin/console doctrine:fixtures:load ```
### Trying the installed project
This API use [OAuth2](https://oauth.net/2/) to authenticate users. The OAuth2 grant type for this project is 'Resource-Owner-Password-Credentails-Grant' more simply called 'password'. 
To test the project, you'll need to be authenticated, so it requires to have at least one client (procedure for adding a client is explained below) and one user created (use test datas above (recommended) or create your own user) in order to authenticate via OAuth2.  

#### 1. How to create a client
To create a client, run the following command in the project directory :  
```php bin/console createClient```
This will create a client with OAuth2 grand type set to 'password'.  
The command will give you a 'client_id' and a 'client_secret' which will be required to authenticate a user in the API.  
If you want to use a different grant_type/authentication flow, please create your own command.

#### 2. a. Trying the project with the API Documentation Sandbox
You can test the project directly in the API Documentation Sandbox.  
To do so, go to ```/api/doc (http://url-pointing-to-yourproject/api/doc)```.  (This route does not requires authentication)  
You'll then see a list of every request you can make to the API.  
  
![Api Documentation preview](https://github.com/ffouillet/RESTful_API_BileMo/blob/master/web/img/github_readme/api_doc.jpg)  
  
Each request you can make requires you to be authenticated.
To authenticate, just click the 'Authorize' Button.  
  
![Api Documentation preview](https://github.com/ffouillet/RESTful_API_BileMo/blob/master/web/img/github_readme/authorize_button.jpg)  
  
Then fill input fields with requested informations :  
```username``` : demoUser (leaves it as is if you use the demo user or set your own if you created a user)  
```password``` : demoPassword (leaves it as is if you use the demo user or set your own if you created a user)  
```type``` : Request body  
```client_id``` : client_id given by the createClient command (see 1. How to create a client)  
``` client_secret ``` : client secret given by the createClient command (see 1. How to create a client)  

If the information you sent are correct, you are now logged in and able to send request to the API.  
Just click on a request you want to send then click the 'Try Out' button on the right, fill the parameters if you want (or leaves it at default) and hit the Execute button below parameters. 
You'll be able to see API Response in the 'Responses' section, just below the 'Execute' button.  
__Warning__ : If you are not authenticated, each request will result in a 401 Unauthorized Response. 

#### 2. b. Trying the project manually (manually forging request)
You can also test the project by manually forging your request with your favorite client (e.g. [Postman](https://www.getpostman.com/)).
In order to request the API, you'll have to get an Access Token first because API is protected and requires you to be authenticated.

#### 2. b. 1. Getting an AccessToken 
To get an Access Token you'll have to send a POST request at the following url : ```/oauth/v2/token``` with a JSON object in the request body containing following informations : 
```json
{
    "client_id": "client_id given by the createClient command (see 1. How to create a client) ",
    "client_secret" : "client secret given by the createClient command (see 1. How to create a client)",
    "grant_type" : "password", 
    "username" : "demoUser (leaves it as is if you use the demo user or set your own if you created a user)",
    "password" : "demoPassword (leaves it as is if you use the demo user or set your own if you created a user)"
}
```
Don't forget to add the ```Content-Type: application/json``` to your request header before sending it. 
If you sent the request correctly, API will respond with a 200 HTTP Status code and an Access Token allowing you to forge and send requests to it.

#### 3. Requesting the API
Now that you have your Access Token, you can start requesting the API.
For each request, you'll have to include your Access Token in the Request Headers like this :  
Header key : ```Authorization```  
Header value : ```Bearer REPLACEWITHYOURACCESSTOKEN```

__Warning__ : If you are not authenticated, each request will result in a 401 Unauthorized Response. 

To see requests you can send, please refer you to the API Documentation.

## Recommandations
OAuth2 must be used with HTTPS for exchanges between clients and servers because sensitive datas (tokens and credentials) are transiting between the two parties.
You can use this project without HTTPS but be aware that doing so opens a big security breach in your application.