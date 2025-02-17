
## registration api

```
endpoint: /api/register;
Method:POST
Header:
'Content-Type': 'Application/json'
Body:
JSON
{
    "name": "Admin user", 
    "email": "admin@gmail.com", 
    "password": "Admin123", 
    "role": "admin" 
}
by default role: counselor
```

## Login API

```
endpoint: api/login;
Method:POST
Header:
'Content-Type': 'Application/json'
Body:
JSON
{
    "email": "admin@gmail.com", 
    "password": "Admin123"
}

```
## logOut

```
endpoint: api/logout;
Method:POST
Header:
'Authorization': 'Bearer $access_token'

```
## Create Lead API

```
endpoint: api/leads;
Method:POST
Header:
'Content-Type': 'Application/json'
'Authorization': 'Bearer $access_token'
Body:
JSON
{
    "name": "David",
    "email": "david123@gmail.com",
    "phone": "12344597864",
    "status": "In Progress",
    "counselor_id": 2
}
Only Admin create lead
```
## Update Lead API
```
endpoint: api/leads/{id};
Method:POST
Header:
'Content-Type': 'Application/json'
'Authorization': 'Bearer $access_token'
Body:
JSON
{
    "name": "David",
    "email": "david123@gmail.com",
    "phone": "12344597864",
    "status": "In Progress",
    "counselor_id": 2
}
Counselor update lead

```
## Viewe all Lead API
```
Admin view all lead
endpoint: api/leads;
Method:GET
Header:
'Content-Type': 'Application/json'
'Authorization': 'Bearer $access_token'
```

## Viewe couselor individual lead
```
Counselor view their assign  lead
endpoint: api/counselor-leads;
Method:GET
Header:
'Content-Type': 'Application/json'
'Authorization': 'Bearer $access_token'
```


## move the laed to Application
```
Counselor login and make their lead to application
endpoint: api/applications;
Method:POST
Header:
'Content-Type': 'Application/json'
'Authorization': 'Bearer $access_token'
{
    "lead_id": 107,
    "counselor_id": 2,
    "status": "In Progress"
}
```

## Update the Application
```
endpoint: api/applications/{id};
Method:POST
Header:
'Content-Type': 'Application/json'
'Authorization': 'Bearer $access_token'
{
    "status": "In Progress"
}
```

## View All Application
```
endpoint: api/applications;
Method:GET
Header:
'Content-Type': 'Application/json'
'Authorization': 'Bearer $access_token'
{
    "status": "In Progress"
}
```

## Admin view counselor

```
endpoint: api/counselor-list;
Method:GET
Header:
'Content-Type': 'Application/json'
'Authorization': 'Bearer $access_token'
```

## user own information

```
endpoint: api/me;
Method:GET
Header:
'Content-Type': 'Application/json'
'Authorization': 'Bearer $access_token'

```