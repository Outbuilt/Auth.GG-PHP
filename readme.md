# Auth.GG Licensing for PHP

This API serves as a layer that simplifies communication between PHP and the server

> Theme designed by colorlib.com under the CC BY 3.0 license

> You can access the documentation of the API at https://setup.auth.gg

# Getting started

### Grab API Secret

* **Step 1** : Login to your panel and create your application
* **Step 2** : Your application secret will be next to your application name
* **Step 3** : Copy your secret and store it somewhere
### Grab AID
* **Step 1** : Login to your panel hover over your avatar on the top right
* **Step 2** : Click on ``Account Settings``
* **Step 3** : Copy your AID and store it somewhere

### Connecting panel to your website
Now that you have your ``AID`` and ``Secret`` use it to initialize and connect your application to our servers
```
include ("api/authgg.php");
AuthGG::Initialize("AIDHERE", "SECRETHERE");
```
## Example
```
 AuthGG::Initialize("269868", "t5d7rzzbrdAHmfWTGmuTUazjLIvWk");
```
## Login

```
if (AuthGG::Login($username, $password))
    {
    //Code you want to do here on successful login
    }
```
> After a successful login, the server will send back the following information on your user encoded in json
* ``username`` : Users username 
* ``id`` : Users ID
* ``email`` : Users email
* ``ip`` : Users IP
* ``variable`` : Users variable
* ``rank`` : Users rank
* ``expiry`` : Users expiry
* ``lastlogin`` : Users last login
## Register

```
 if (AuthGG::Register($username, $password, $email, $license))
    {
    //Code you want to do here on successful register
    }
```
## Extend Subscription
```
 if (AuthGG::Extend($username, $password, $license))
    {
    // Do code of what you want after successful extend here!
    }
```
## Log Action
```
AuthGG::Log("User logged in");
AuthGG::Log("Failed login");
```
