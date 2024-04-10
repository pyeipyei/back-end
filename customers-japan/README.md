# API Gateway

This is the customer-japan of all services that are composed under this gateway.

## Logical Diagram

```
API customer-japn -> Auth -> Customer Service
                    -> ...
```

<table>
    <thead>
        <th>Screen Name</th>
        <th>Endpoint</th>
        <th>Method</th>
        <th>Description</th>
        <th>Payload</th>
        <th>Response</th>
    </thead>

   <!-- For Customers -->
   <tr>
        <td>Customers Page</td>
        <td>/customers</td>
        <td>GET</td>
        <td>Get all customers</td>
        <td><pre>
            Request:{}</pre>
        </td>
        <td><pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id":2,
                                "customer_cd":"000002",
                                "customer_name":"gic",
                                "email":null,
                                "phone":null,
                                "address":null,
                                "created_date":"2017-04-05 11:57:43",
                                "modified_date":"2017-04-05 11:57:43",
                                "location":"Japan"
                            }
                ]
            }</pre>
        </td>
    </tr>
    <!-- For search Customers -->
    <tr>
        <td>Customers Page</td>
        <td>/customers/search</td>
        <td>GET</td>
        <td>Get search customer</td>
        <td><pre>
            Request:{
                 filter[customer_name]=アクセンチュア株式会社
            }</pre>
        </td>
        <td><pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id":2,
                                "customer_cd":"000002",
                                "customer_name":"gic",
                                "email":null,
                                "phone":null,
                                "address":null,
                                "created_date":"2017-04-05 11:57:43",
                                "modified_date":"2017-04-05 11:57:43",
                                "location":"Japan"
                            }
                ]
            }</pre>
        </td>
    </tr>
    <!-- For search Customers -->
    <tr>
        <td>Customers Page</td>
        <td>/customers/search</td>
        <td>GET</td>
        <td>Get search customer</td>
        <td><pre>
            Request:{
                 filter[customer_name]=アクセンチュア株式会社
            }</pre>
        </td>
        <td><pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id":2,
                                "customer_cd":"000002",
                                "customer_name":"gic",
                                "email":null,
                                "phone":null,
                                "address":null,
                                "created_date":"2017-04-05 11:57:43",
                                "modified_date":"2017-04-05 11:57:43",
                                "location":"Japan"
                            }
                ]
            }</pre>
        </td>
    </tr>
    <!-- For Insert New Customer -->
    <tr>
        <td>Customer Page</td>
        <td>customers/create</td>
        <td>POST</td>
        <td>Insert new customer</td>
        <td><pre>
        Request:{
                    "customer_cd":"0002",
                    "customer_name":"tanaka",
                    "email":"123",
                    "phone":"12344555",
                    "address":"Yangon"
                }</pre>
        </td>
        <td><pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }</pre>
        </td>
    </tr>
    <!-- For Update customer -->
    <tr>
        <td>Customer Page</td>
        <td>/customers/update/{customer_cd}</td>
        <td>PUT</td>
        <td>Update customer</td>
        <td><pre>
            Request:{
                    "id": 1
                    "customer_cd":"666666",
                    "customer_name":"田666中",
                    "email":"tanaka@gmail.com",
                    "phone":"111",
                    "address":"111"
            }</pre>
        </td>
        <td><pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }</pre>
        </td>
    </tr>
    <!-- For Delete Customer -->
    <tr>
        <td>Customer Page</td>
        <td>ustomers/delete/{customer_cd}</td>
        <td>DELETE</td>
        <td>Destroy Customer</td>
        <td><pre>
            Request:{
            "customer_cd": "000002",
            }</pre>
        </td>
        <td><pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }</pre>
        </td>
    </tr>
 
</table>
