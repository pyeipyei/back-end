# API Gateway

This is the API gateway of all services that are composed under this gateway.

## Logical Diagram

```
API Gateway -> Auth -> Software Engineer Service
                    -> Employees Service
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
    <!-- For Employees -->
    <tr>
        <td>Employees Page</td>
        <td>/employees</td>
        <td>GET</td>
        <td>Get all employees</td>
        <td><pre>Request:{}</pre></td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                    {
                        "id":1,
                        "emp_cd":"1001",
                        "emp_name":"Mg Mg",
                        "position":"1",
                        "created_date":"2017-05-19 00:00:00",
                        "modified_date":"2017-05-19 00:00:00",
                        "group_cd":"",
                        "gl_flag":"",
                        "activation_code":null,
                        "emp_email":null,
                        "location":"Myanmar"
                    }...
                ]
            }
        </pre> 
        </td>
    </tr>
    <!-- For search Employees -->
    <tr>
        <td>Employees Page</td>
        <td>/employees/search</td>
        <td>GET</td>
        <td>Get search employee</td>
        <td>
        <pre>
            Request:{filter[emp_name]=Mg Mg}
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id":1,
                                "emp_cd":"1001",
                                "emp_name":"Mg Mg",
                                "position":"1",
                                "created_date":"2017-05-19 00:00:00",
                                "modified_date":"2017-05-19 00:00:00",
                                "group_cd":"",
                                "gl_flag":"",
                                "activation_code":null,
                                "emp_email":null,
                                "location":"Myanmar"
                            }
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Customers -->
    <tr>
        <td>Customers Page</td>
        <td>/customers</td>
        <td>GET</td>
        <td>Get all customers</td>
        <td>
        <pre>
            Request:{}
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id":2,
                                "customer_cd":"000002",
                                "customer_name":"new company",
                                "email":null,
                                "phone":null,
                                "address":null,
                                "created_date":"2017-04-05 11:57:43",
                                "modified_date":"2017-04-05 11:57:43",
                                "location":"Japan"
                            }
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For search Customers -->
    <tr>
        <td>Customers Page</td>
        <td>/customers/search</td>
        <td>GET</td>
        <td>Get search customer</td>
        <td>
        <pre>
            Request:{
                 filter[customer_name]=new company
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id":2,
                                "customer_cd":"1001",
                                "customer_name":"new company",
                                "email":null,
                                "phone":null,
                                "address":null,
                                "created_date":"2017-04-05 11:57:43",
                                "modified_date":"2017-04-05 11:57:43",
                                "location":"Japan"
                            }
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Get All Departments -->
    <tr>
        <td>Departments Page</td>
        <td>/departments</td>
        <td>GET</td>
        <td>Get all departments</td>
        <td>
        <pre>
            Request:{}
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id": 1,
                                "department_name": "Sales",
                                "marketing_name": 201501,
                                "department_head": "10001",
                            }
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Insert New Department -->
    <tr>
        <td>Departments Page</td>
        <td>/departmetns</td>
        <td>POST</td>
        <td>Insert new department</td>
        <td>
        <pre>
            Request:{
            "department_name": "Sales",
            "marketing_name": 201501,
            "department_head": "10001",
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Get Edit Department -->
    <tr>
        <td>Departments Page</td>
        <td>/departments/{department}</td>
        <td>GET</td>
        <td>Get department edit data by Id</td>
        <td>
        <pre>
            Request:{ 
            "id": 1,
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                    "id": 1,
                    "department_name": "Sales",
                    "marketing_name": 201501,
                    "department_head": "10001",
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Update Department -->
    <tr>
        <td>Departments Page</td>
        <td>/departments/{department}</td>
        <td>PUT</td>
        <td>Update department</td>
        <td>
        <pre>
            Request:{
            "id": 1,
            "department_name": "Maketing",
            "marketing_name": 201501,
            "department_head": "10001",
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Delete Department -->
    <tr>
        <td>Departments Page</td>
        <td>/departments/{department}</td>
        <td>DELETE</td>
        <td>Destroy department</td>
        <td>
        <pre>
            Request:{
            "id": 1,
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Get All Projects -->
    <tr>
        <td>Projects Page</td>
        <td>/projects</td>
        <td>GET</td>
        <td>Get all projects</td>
        <td>
            Request:{}
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                    {
                            "id": 3,
                            "ses_project_leader": "aung aung",
                            "ses_estimate_number": "1000000001",
                            "ses_approval_number": "100000",
                            "ses_order_number": "33754",
                            "ses_delivery_date": "1997-10-30",
                            "ses_pm_man_month": 1,
                            "ses_pm_average_unit_price": 5000,
                            "ses_pl_man_month": 1,
                            "ses_pl_average_unit_price": 2000,
                            "ses_se_man_month": 5,
                            "ses_se_average_unit_price": 1000,
                            "ses_pg_man_month": 5,
                            "ses_pg_average_unit_price": 800,
                            "ses_oh_man_month": 2,
                            "ses_oh_average_unit_price": 400,
                            "ses_order_amount": 16800,
                            "ses_acceptance_billing_date": "2003-08-12",
                            "ses_payment_date": "1987-05-01",
                            "jp_project_leader": null,
                            "jp_estimate_number": null,
                            "jp_approval_number": null,
                            "jp_order_number": null,
                            "jp_delivery_date": null,
                            "jp_pm_man_month": null,
                            "jp_pm_average_unit_price": null,
                            "jp_pl_man_month": null,
                            "jp_pl_average_unit_price": null,
                            "jp_se_man_month": null,
                            "jp_se_average_unit_price": null,
                            "jp_pg_man_month": null,
                            "jp_pg_average_unit_price": null,
                            "jp_oh_man_month": null,
                            "jp_oh_average_unit_price": null,
                            "jp_order_amount": null,
                            "jp_acceptance_billing_date": null,
                            "jp_payment_date": null,
                            "mm_project_leader": null,
                            "mm_estimate_number": null,
                            "mm_approval_number": null,
                            "mm_order_number": null,
                            "mm_delivery_date": null,
                            "mm_pm_man_month": null,
                            "mm_pm_average_unit_price": null,
                            "mm_pl_man_month": null,
                            "mm_pl_average_unit_price": null,
                            "mm_se_man_month": null,
                            "mm_se_average_unit_price": null,
                            "mm_pg_man_month": null,
                            "mm_pg_average_unit_price": null,
                            "mm_oh_man_month": null,
                            "mm_oh_average_unit_price": null,
                            "mm_gicj_fee": null,
                            "mm_order_amount": null,
                            "mm_billing_amount": null,
                            "mm_acceptance_billing_date": null,
                            "mm_payment_date": null,
                            "project_type_id": 1,
                            "project_id": 1,
                            "created_at": "2023-10-12T07:38:56.000000Z",
                            "updated_at": "2023-10-12T07:38:56.000000Z",
                            "deleted_at": null,
                            "project": {
                                "id": 2,
                                "year": "2013",
                                "project_name": "Project1",
                                "contract_number": "40075",
                                "customer_id": 2,
                                "payment_status": "waiting",
                                "marketing_name": "marketing1",
                                "start_date": "1991-03-30",
                                "end_date": "2010-07-08",
                                "contract_status": "waiting",
                                "department_id": 3,
                                "user_id": null,
                                "created_at": "2023-10-12T07:38:56.000000Z",
                                "updated_at": "2023-10-12T07:38:56.000000Z",
                                "deleted_at": null,
                                "customer": {
                                    "id": 2,
                                    "customer_cd": "000002",
                                    "customer_name": "new customer",
                                    "email": null,
                                    "phone": null,
                                    "address": null,
                                    "created_date": "2017-04-05 11:57:43",
                                    "modified_date": "2017-04-05 11:57:43"
                                },
                                "department": {
                                    "id": 3,
                                    "department_name": "IT",
                                    "marketing_name": "201501",
                                    "department_head": "10001",
                                    "user_id": null,
                                    "created_at": "2023-10-12T07:38:56.000000Z",
                                    "updated_at": "2023-10-12T07:38:56.000000Z",
                                    "deleted_at": null
                                }
                            },
                            "project_type": {
                                "id": 1,
                                "project_type": "Offshore",
                                "created_at": "2023-10-12T07:38:56.000000Z",
                                "updated_at": "2023-10-12T07:38:56.000000Z"
                            }
                        }
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Insert New Project -->
    <tr>
        <td>Projects Page</td>
        <td>/projects</td>
        <td>POST</td>
        <td>Insert new project</td>
        <td>
        <pre>
        Request:{
                    "year": "2013",
                    "project_name": "new Project",
                    "contract_number": "40075",
                    "customer_id": 2,
                    "payment_status": "waiting",
                    "marketing_name": "new marketing2",
                    "start_date": "1991-03-30",
                    "end_date": "2010-07-08",
                    "contract_status": "waiting",
                    "department_id": 3,
                    "user_id": null,
                }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Get Edit Project -->
    <tr>
        <td>Projects Page</td>
        <td>/projects/{id}/edit</td>
        <td>GET</td>
        <td>Get project edit data by Id</td>
        <td>
        <pre>
            Request:{ 
            "id": 1,
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                           {
                            "id": 3,
                            "ses_project_leader": "new leader",
                            "ses_estimate_number": "20572630",
                            "ses_approval_number": "84457",
                            "ses_order_number": "33754",
                            "ses_delivery_date": "1997-10-30",
                            "ses_pm_man_month": 1,
                            "ses_pm_average_unit_price": 5000,
                            "ses_pl_man_month": 1,
                            "ses_pl_average_unit_price": 2000,
                            "ses_se_man_month": 5,
                            "ses_se_average_unit_price": 1000,
                            "ses_pg_man_month": 5,
                            "ses_pg_average_unit_price": 800,
                            "ses_oh_man_month": 2,
                            "ses_oh_average_unit_price": 400,
                            "ses_order_amount": 16800,
                            "ses_acceptance_billing_date": "2003-08-12",
                            "ses_payment_date": "1987-05-01",
                            "jp_project_leader": null,
                            "jp_estimate_number": null,
                            "jp_approval_number": null,
                            "jp_order_number": null,
                            "jp_delivery_date": null,
                            "jp_pm_man_month": null,
                            "jp_pm_average_unit_price": null,
                            "jp_pl_man_month": null,
                            "jp_pl_average_unit_price": null,
                            "jp_se_man_month": null,
                            "jp_se_average_unit_price": null,
                            "jp_pg_man_month": null,
                            "jp_pg_average_unit_price": null,
                            "jp_oh_man_month": null,
                            "jp_oh_average_unit_price": null,
                            "jp_order_amount": null,
                            "jp_acceptance_billing_date": null,
                            "jp_payment_date": null,
                            "mm_project_leader": null,
                            "mm_estimate_number": null,
                            "mm_approval_number": null,
                            "mm_order_number": null,
                            "mm_delivery_date": null,
                            "mm_pm_man_month": null,
                            "mm_pm_average_unit_price": null,
                            "mm_pl_man_month": null,
                            "mm_pl_average_unit_price": null,
                            "mm_se_man_month": null,
                            "mm_se_average_unit_price": null,
                            "mm_pg_man_month": null,
                            "mm_pg_average_unit_price": null,
                            "mm_oh_man_month": null,
                            "mm_oh_average_unit_price": null,
                            "mm_gicj_fee": null,
                            "mm_order_amount": null,
                            "mm_billing_amount": null,
                            "mm_acceptance_billing_date": null,
                            "mm_payment_date": null,
                            "project_type_id": 1,
                            "project_id": 1,
                            "created_at": "2023-10-12T07:38:56.000000Z",
                            "updated_at": "2023-10-12T07:38:56.000000Z",
                            "deleted_at": null,
                            "project": {
                                "id": 1,
                                "year": "2013",
                                "project_name": "new Project",
                                "contract_number": "40075",
                                "customer_id": 2,
                                "payment_status": "waiting",
                                "marketing_name": "new marketing2",
                                "start_date": "1991-03-30",
                                "end_date": "2010-07-08",
                                "contract_status": "waiting",
                                "department_id": 3,
                                "user_id": null,
                                "created_at": "2023-10-12T07:38:56.000000Z",
                                "updated_at": "2023-10-12T07:38:56.000000Z",
                                "deleted_at": null,
                                "customer": {
                                    "id": 2,
                                    "customer_cd": "000002",
                                    "customer_name": "new customer",
                                    "email": null,
                                    "phone": null,
                                    "address": null,
                                    "created_date": "2017-04-05 11:57:43",
                                    "modified_date": "2017-04-05 11:57:43"
                                },
                                "department": {
                                    "id": 3,
                                    "department_name": "IT",
                                    "marketing_name": "201501",
                                    "department_head": "10001",
                                    "user_id": null,
                                    "created_at": "2023-10-12T07:38:56.000000Z",
                                    "updated_at": "2023-10-12T07:38:56.000000Z",
                                    "deleted_at": null
                                }
                            },
                            "project_type": {
                                "id": 1,
                                "project_type": "new Project Type",
                                "created_at": "2023-10-12T07:38:56.000000Z",
                                "updated_at": "2023-10-12T07:38:56.000000Z"
                            }
                        }
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Update Project -->
    <tr>
        <td>Projects Page</td>
        <td>/projects/{id}</td>
        <td>PUT</td>
        <td>Update project</td>
        <td>
        <pre>
            Request:{
                    "id": 1
                    "year": "2014",
                    "project_name": "new Project1",
                    "contract_number": "40075",
                    "customer_id": 2,
                    "payment_status": "waiting",
                    "marketing_name": "new marketing2",
                    "start_date": "1991-03-30",
                    "end_date": "2010-07-08",
                    "contract_status": "waiting",
                    "department_id": 3,
                    "user_id": null,
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </td>
        </pre>
    </tr>
    <!-- For Delete Project -->
    <tr>
        <td>Projects Page</td>
        <td>/projects/delete</td>
        <td>DELETE</td>
        <td>Destroy project</td>
        <td>
        <pre>
            Request:{
            "id": 1,
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For filter Project -->
    <tr>
        <td>Projects Page</td>
        <td>/projects</td>
        <td>GET</td>
        <td>Get filter projects</td>
        <td>
        <pre>
            Request:{
                filter[project_name]=new Project1
                }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                    {
                    "id": 1
                    "year": "2014",
                    "project_name": "new Project1",
                    "contract_number": "40075",
                    "customer_id": 2,
                    "payment_status": "waiting",
                    "marketing_name": "new marketing2",
                    "start_date": "1991-03-30",
                    "end_date": "2010-07-08",
                    "contract_status": "waiting",
                    "department_id": 3,
                    "user_id": null,
            }
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For search Project -->
    <tr>
        <td>Projects Page</td>
        <td>/projects/search</td>
        <td>GET</td>
        <td>Get search project</td>
        <td>
        <pre>
            Request:{
                 filter[project_name]=new Project1
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                    {
                    "id": 1
                    "year": "2014",
                    "project_name": "new Project1",
                    "contract_number": "40075",
                    "customer_id": 2,
                    "payment_status": "waiting",
                    "marketing_name": "new marketing2",
                    "start_date": "1991-03-30",
                    "end_date": "2010-07-08",
                    "contract_status": "waiting",
                    "department_id": 3,
                    "user_id": null,
            }
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Get All Roles -->
    <tr>
        <td>Roles Page</td>
        <td>/roles</td>
        <td>GET</td>
        <td>Get all roles</td>
        <td>
            Request:{}
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                        {
                            "id": 1,
                            "role_name": "Junior Engineer",
                            "created_at": "2023-10-12T07:38:56.000000Z",
                            "updated_at": "2023-10-12T07:38:56.000000Z",
                            "deleted_at": null
                        },
                        {
                            "id": 2,
                            "role_name": "Senior Engineer",
                            "created_at": "2023-10-12T07:38:56.000000Z",
                            "updated_at": "2023-10-12T07:38:56.000000Z",
                            "deleted_at": null
                        }                    
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Insert New Role -->
    <tr>
        <td>Roles Page</td>
        <td>/roles</td>
        <td>POST</td>
        <td>Insert new role</td>
        <td>
        <pre>
        Request:{
                "role_name": "Project Manager",
                }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Get Edit Role -->
    <tr>
        <td>Roles Page</td>
        <td>/roles/{role}</td>
        <td>GET</td>
        <td>Get role edit data by Id</td>
        <td>
        <pre>
            Request:{ 
            "id": 2,
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                        {
                            "id": 2,
                            "role_name": "Senior Engineer",
                            "created_at": "2023-10-12T07:38:56.000000Z",
                            "updated_at": "2023-10-12T07:38:56.000000Z",
                            "deleted_at": null
                        }
                    ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Update Role -->
    <tr>
        <td>Roles Page</td>
        <td>/roles/{role}</td>
        <td>PUT</td>
        <td>Update role</td>
        <td>
        <pre>
            Request:{
                    "id": 1
                    "role_name": "sub leader",
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Delete Role -->
    <tr>
        <td>Roles Page</td>
        <td>/roles/{role}</td>
        <td>DELETE</td>
        <td>Destroy role</td>
        <td>
        <pre>
            Request:{
            "id": 1,
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For search Role -->
    <tr>
        <td>Roles Page</td>
        <td>/roles/search</td>
        <td>GET</td>
        <td>Get search role</td>
        <td>
        <pre>
            Request:{
                 filter[role_name]=sub leader
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                    {
                        "id": 2,
                        "role_name": "sub leader",
                        "created_at": "2023-10-12T07:38:56.000000Z",
                        "updated_at": "2023-10-12T07:38:56.000000Z",
                        "deleted_at": null
            }
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Insert Engineer Assign -->
    <tr>
        <td>Engineer Assign Page</td>
        <td>/assign/engineers</td>
        <td>POST</td>
        <td>Insert new engineer assign</td>
        <td>
        <pre>
        Request:{
                    "customer_id": 1,
                    "project_id": 2,
                    "start_date": "2025-07-05",
                    "end_date": "2026-10-05",
                    "projectEmployees": [
                    {
                        "role": 1,
                        "hour": 30,
                        "unit_price": 50,
                        "employeesId": ["0004", "0006" ,"0006"]
                    },
                    {
                        "role": 2,
                        "hour": 40,
                        "unit_price": 100,
                        "employeesId": ["0014", "0015"]
                    }
                    ]
                }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Get All Project Types -->
    <tr>
        <td>Project Types Page</td>
        <td>/project_types</td>
        <td>GET</td>
        <td>Get all project types</td>
        <td>
        <pre>
            Request:{}
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id": 1,
                                "project_type": "new Project Type",
                                "created_at": "2023-10-12T07:38:56.000000Z",
                                "updated_at": "2023-10-12T07:38:56.000000Z"
                            },
                            {
                                "id": 2,
                                "project_type": "Offshore(Myanmar)",
                                "created_at": "2023-10-12T07:38:56.000000Z",
                                "updated_at": "2023-10-12T07:38:56.000000Z"
                            }                  
                    ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Insert New Project Types -->
    <tr>
        <td>Project Types Page</td>
        <td>/project_types</td>
        <td>POST</td>
        <td>Insert new project types</td>
        <td>
        <pre>
        Request:{
                 "project_type": "Offshore(Japan)",
                }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Get Edit Project Types -->
    <tr>
        <td>Project Types Page</td>
        <td>/project_types/{project_type}</td>
        <td>GET</td>
        <td>Get project types edit data by Id</td>
        <td>
        <pre>
            Request:{ 
            "id": 2,
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                        {
                            "id": 2,
                            "project_type": "Offshore(Myanmar)",
                            "created_at": "2023-10-12T07:38:56.000000Z",
                            "updated_at": "2023-10-12T07:38:56.000000Z"
                        }
                    ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Update Project Types -->
    <tr>
        <td>Project Types Page</td>
        <td>/project_types/{project_type}</td>
        <td>PUT</td>
        <td>Update project types</td>
        <td>
        <pre>
            Request:{
                    "id": 1
                    "project_type": "Offshore(Myanmar)",
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Delete Project Types -->
    <tr>
        <td>Project Types Page</td>
        <td>/project_types/{project_type}</td>
        <td>DELETE</td>
        <td>Destroy Project Types</td>
        <td>
        <pre>
            Request:{
            "id": 1,
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Get All Project Assign -->
    <tr>
        <td>Project Assign Page</td>
        <td>/assign/projects</td>
        <td>GET</td>
        <td>Get all project assign</td>
        <td>
        <pre>
            Request:{}
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id": 2,
                                "employee_code": "000001",
                                "january": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 1
                                },
                                "february": {
                                    "role_id": 2,
                                    "role": "Senior Engineer",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 2
                                },
                                "march": {
                                    "role_id": 3,
                                    "role": "PM",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 3
                                },
                                "april": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 2,
                                    "project_name": "Project",
                                    "department_name": "Marketing",
                                    "project_type": "new Project Type",
                                    "number": 4
                                },
                                "may": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 2,
                                    "project_name": "Project",
                                    "department_name": "Marketing",
                                    "project_type": "new Project Type",
                                    "number": 5
                                },
                                "june": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 3,
                                    "project_name": "ITS Tools",
                                    "department_name": "IT",
                                    "project_type": "new Project Type",
                                    "number": 6
                                },
                                "july": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 3,
                                    "project_name": "ITS Tools",
                                    "department_name": "IT",
                                    "project_type": "new Project Type",
                                    "number": 7
                                },
                                "august": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 3,
                                    "project_name": "ITS Tools",
                                    "department_name": "IT",
                                    "project_type": "new Project Type",
                                    "number": 8
                                },
                                "september": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 3,
                                    "project_name": "ITS Tools",
                                    "department_name": "IT",
                                    "project_type": "new Project Type",
                                    "number": 9
                                },
                                "october": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 3,
                                    "project_name": "ITS Tools",
                                    "department_name": "IT",
                                    "project_type": "new Project Type",
                                    "number": 10
                                },
                                "november": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 3,
                                    "project_name": "ITS Tools",
                                    "department_name": "IT",
                                    "project_type": "new Project Type",
                                    "number": 11
                                },
                                "december": {
                                    "role_id": null,
                                    "role": null,
                                    "project_id": null,
                                    "project_name": "待機",
                                    "department_name": null,
                                    "project_type": null,
                                    "number": null
                                },
                                "proposal_status": "Assign in new Project",
                                "careersheet_status": 0,
                                "careersheet_link": "https://www.example.com/careersheet.pdf",
                                "man_hour": 1,
                                "unit_price": 10,
                                "year": 2023,
                                "user_id": null,
                                "maketing_status": "not available",
                                "created_at": "2023-10-12T07:38:56.000000Z",
                                "updated_at": "2023-10-12T07:38:56.000000Z",
                                "status": [
                                    {
                                        "id": 1,
                                        "status_name": "not available",
                                        "created_at": "2023-10-12T07:38:56.000000Z",
                                        "updated_at": "2023-10-12T07:38:56.000000Z"
                                    }
                                ],
                                "employeeData": {
                                    "employee_code": "000002",
                                    "employee_name": "山田",
                                    "location": "Japan"
                                },
                                "currentAssign": {
                                    "current_status": "assigned",
                                    "current_project": "ITS Tools",
                                    "current_projectType": "new Project Type",
                                    "department": "IT"
                                },
                                "update_flag": true
                            },                  
                ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Insert New Project Assign -->
    <tr>
        <td>Project Assign Page</td>
        <td>/assign/projects</td>
        <td>POST</td>
        <td>Insert new role</td>
        <td>
        <pre>
        Request:{
                    "employee_code": "0016",
                    "maketing_status": "not available",
                    "proposal_status": "proposal_status",
                    "careersheet_status": 1,
                    "careersheet_link": "www.careersheet7.xml",
                    "man_hour": 11,
                    "unit_price": 40,
                    "year": 2024,
                    "january" :  [
                        {
                        "role": 2,
                        "project_id": 1
                        }
                    ],
                    "february" :  [
                        {
                        "role": 2,
                        "project_id": 1
                        }
                    ],
                    "march" :  [
                        {
                        "role": 2,
                        "project_id": 1
                        }
                    ],
                    "april" :  [
                        {
                        "role": 2,
                        "project_id": 1
                        }
                    ],
                    "may" :  [
                        {
                        "role": 3,
                        "project_id": 2
                        }
                    ],
                    "june" :  [
                        {
                        "role": 3,
                        "project_id": 2
                        }
                    ],
                    "july" :  [
                        {
                        "role": 3,
                        "project_id": 2
                        }
                    ],
                    "august" :  [
                        {
                        "role": 1,
                        "project_id": 1
                        }
                    ],
                    "september" :  [
                        {
                        "role": 1,
                        "project_id": 1
                        }
                    ],
                    "october" :  [
                        {
                        "role": 1,
                        "project_id": 1
                        }
                    ],
                    "november" :  [
                        {
                        "role": 1,
                        "project_id": 1
                        }
                    ],
                    "december" :  [
                        {
                        "role": 1,
                        " project_id": 1
                        }
                    ]
                }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Get Edit Project Assign -->
    <tr>
        <td>Project Assign Page</td>
        <td>/assign/projects/{id}/edit</td>
        <td>GET</td>
        <td>Get project assign edit data by Id</td>
        <td>
        <pre>
            Request:{ 
            "id": 2,
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                        {
                            "id": 2,
                            "employee_code": "0000002",
                            "january": {
                                "role_id": 2,
                                "role": "Senior Engineer",
                                "project_id": 1,
                                "project_name": "new Project",
                                "department_name": "Sales",
                                "project_type": "new Project Type",
                                "number": 1
                            },
                            "february": {
                                "role_id": 2,
                                "role": "Senior Engineer",
                                "project_id": 1,
                                "project_name": "new Project",
                                "department_name": "Sales",
                                "project_type": "new Project Type",
                                "number": 2
                            },
                            "march": {
                                "role_id": 2,
                                "role": "Senior Engineer",
                                "project_id": 1,
                                "project_name": "new Project",
                                "department_name": "Sales",
                                "project_type": "new Project Type",
                                "number": 3
                            },
                            "april": {
                                "role_id": 2,
                                "role": "Senior Engineer",
                                "project_id": 1,
                                "project_name": "new Project",
                                "department_name": "Sales",
                                "project_type": "new Project Type",
                                "number": 4
                            },
                            "may": {
                                "role_id": 3,
                                "role": "PM",
                                "project_id": 2,
                                "project_name": "Project",
                                "department_name": "Marketing",
                                "project_type": "new Project Type",
                                "number": 5
                            },
                            "june": {
                                "role_id": 3,
                                "role": "PM",
                                "project_id": 2,
                                "project_name": "Project",
                                "department_name": "Marketing",
                                "project_type": "new Project Type",
                                "number": 6
                            },
                            "july": {
                                "role_id": 3,
                                "role": "PM",
                                "project_id": 2,
                                "project_name": "Project",
                                "department_name": "Marketing",
                                "project_type": "new Project Type",
                                "number": 7
                            },
                            "august": {
                                "role_id": 1,
                                "role": "Junior Engineer",
                                "project_id": 1,
                                "project_name": "new Project",
                                "department_name": "Sales",
                                "project_type": "new Project Type",
                                "number": 8
                            },
                            "september": {
                                "role_id": 1,
                                "role": "Junior Engineer",
                                "project_id": 1,
                                "project_name": "new Project",
                                "department_name": "Sales",
                                "project_type": "new Project Type",
                                "number": 9
                            },
                            "october": {
                                "role_id": 1,
                                "role": "Junior Engineer",
                                "project_id": 1,
                                "project_name": "new Project",
                                "department_name": "Sales",
                                "project_type": "new Project Type",
                                "number": 10
                            },
                            "november": {
                                "role_id": 1,
                                "role": "Junior Engineer",
                                "project_id": 1,
                                "project_name": "new Project",
                                "department_name": "Sales",
                                "project_type": "new Project Type",
                                "number": 11
                            },
                            "december": {
                                "role_id": null,
                                "role": null,
                                "project_id": null,
                                "project_name": "待機",
                                "department_name": null,
                                "project_type": null,
                                "number": null
                            },
                            "proposal_status": "proposal_status",
                            "careersheet_status": 1,
                            "careersheet_link": "www.careersheet7.xml",
                            "man_hour": 11,
                            "unit_price": 40,
                            "year": 2024,
                            "user_id": null,
                            "maketing_status": "not available",
                            "created_at": null,
                            "updated_at": null,
                            "status": [
                                {
                                    "id": 2,
                                    "status_name": "available",
                                    "created_at": "2023-10-12T07:38:56.000000Z",
                                    "updated_at": "2023-10-12T07:38:56.000000Z"
                                }
                            ],
                            "currentAssign": {
                                "current_status": "unassigned",
                                "current_project": null,
                                "current_projectType": null,
                                "department": null
                            },
                            "update_flag": true,
                            "employeeGroup": {
                                "employee_code": "0000002",
                                "employee_name": "Akira Ogasawara"
                            }
                        }
                    ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Update Project Assign -->
    <tr>
        <td>Project Assign Page</td>
        <td>/assign/projects/{id}</td>
        <td>PUT</td>
        <td>Update project assign</td>
        <td>
        <pre>
            Request:{
                    "employee_code": "0017",
                    "maketing_status": "not available",
                    "proposal_status": "proposal_status",
                    "careersheet_status": 0,
                    "careersheet_link": "www.careersheet7.xml",
                    "man_hour": 1,
                    "unit_price": 30,
                    "year": 2024,
                    "january" :  [
                        {
                        "role": 2,
                        "project_id": 1
                        }
                    ],
                    "february" :  [
                        {
                        "role": 2,
                        "project_id": 1
                        }
                    ],
                    "march" :  [
                        {
                        "role": 2,
                        "project_id": 1
                        }
                    ],
                    "april" :  [
                        {
                        "role": 2,
                        "project_id": 1
                        }
                    ],
                    "may" :  [
                        {
                        "role": 3,
                        "project_id": 2
                        }
                    ],
                    "june" :  [
                        {
                        "role": 3,
                        "project_id": 2
                        }
                    ],
                    "july" :  [
                        {
                        "role": 3,
                        "project_id": 2
                        }
                    ],
                    "august" :  [
                        {
                        "role": 1,
                        "project_id": 1
                        }
                    ],
                    "september" :  [
                        {
                        "role": 1,
                        "project_id": 1
                        }
                    ],
                    "october" :  [
                        {
                        "role": 1,
                        "project_id": 1
                        }
                    ],
                    "november" :  [
                        {
                        "role": 1,
                        "project_id": 1
                        }
                    ],
                    "december" :  [
                        {
                        "role": 1,
                        " project_id": 1
                        }
                    ]
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For search Project Assign -->
    <tr>
        <td>Project Assign Page</td>
        <td>/assign/projects/search</td>
        <td>GET</td>
        <td>Get search project assign</td>
        <td>
        <pre>
            Request:{
                 filter[emp_name]=Tom
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                        {
                            "id": 25,
                                "employee_code": "000001",
                                "january": {
                                    "role_id": 2,
                                    "role": "Senior Engineer",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 1
                                },
                                "february": {
                                    "role_id": 2,
                                    "role": "Senior Engineer",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 2
                                },
                                "march": {
                                    "role_id": 2,
                                    "role": "Senior Engineer",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 3
                                },
                                "april": {
                                    "role_id": 2,
                                    "role": "Senior Engineer",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 4
                                },
                                "may": {
                                    "role_id": 3,
                                    "role": "PM",
                                    "project_id": 2,
                                    "project_name": "Project",
                                    "department_name": "Marketing",
                                    "project_type": "new Project Type",
                                    "number": 5
                                },
                                "june": {
                                    "role_id": 3,
                                    "role": "PM",
                                    "project_id": 2,
                                    "project_name": "Project",
                                    "department_name": "Marketing",
                                    "project_type": "new Project Type",
                                    "number": 6
                                },
                                "july": {
                                    "role_id": 3,
                                    "role": "PM",
                                    "project_id": 2,
                                    "project_name": "Project",
                                    "department_name": "Marketing",
                                    "project_type": "new Project Type",
                                    "number": 7
                                },
                                "august": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 8
                                },
                                "september": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 9
                                },
                                "october": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 10
                                },
                                "november": {
                                    "role_id": 1,
                                    "role": "Junior Engineer",
                                    "project_id": 1,
                                    "project_name": "new Project",
                                    "department_name": "Sales",
                                    "project_type": "new Project Type",
                                    "number": 11
                                },
                                "december": {
                                    "role_id": null,
                                    "role": null,
                                    "project_id": null,
                                    "project_name": "待機",
                                    "department_name": null,
                                    "project_type": null,
                                    "number": null
                                },
                                "proposal_status": "proposal_status",
                                "careersheet_status": 1,
                                "careersheet_link": "www.careersheet7.xml",
                                "man_hour": 11,
                                "unit_price": 40,
                                "year": 2024,
                                "user_id": null,
                                "maketing_status": "not available",
                                "created_at": null,
                                "updated_at": null,
                                "status": [
                                    {
                                        "id": 2,
                                        "status_name": "available",
                                        "created_at": "2023-10-12T07:38:56.000000Z",
                                        "updated_at": "2023-10-12T07:38:56.000000Z"
                                    }
                                ],
                                "employeeData": {
                                    "employee_code": "000001",
                                    "employee_name": "naga",
                                    "location": null
                                },
                                "currentAssign": {
                                    "current_status": "unassigned",
                                    "current_project": null,
                                    "current_projectType": null,
                                    "department": null
                                },
                                "update_flag": true
                        }
                    ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Get All costs -->
    <tr>
        <td>Costs Page</td>
        <td>/costs</td>
        <td>GET</td>
        <td>Get all costs</td>
        <td>
        <pre>
            Request:{}
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id": 3,
                                "jp_cost": 16800,
                                "mm_cost": 0,
                                "actual_cost": 0,
                                "project_id": 1,
                                "created_at": "2023-10-12T07:38:56.000000Z",
                                "updated_at": "2023-10-12T07:38:56.000000Z",
                                "deleted_at": null,
                                "project_name": "new Project"
                            },
                            {
                                "id": 2,
                                "jp_cost": 16800,
                                "mm_cost": 0,
                                "actual_cost": 0,
                                "project_id": 2,
                                "created_at": "2023-10-12T07:38:56.000000Z",
                                "updated_at": "2023-10-12T07:38:56.000000Z",
                                "deleted_at": null,
                                "project_name": "Project"
                            }
                    ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Get All member types -->
    <tr>
        <td>MemberTypes Page</td>
        <td>/member/type</td>
        <td>GET</td>
        <td>Get all membertypes</td>
        <td>
        <pre>
            Request:{}
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                        {
                            "member_type_id": 1,
                            "member_type": "Support",
                            "created_at": "2023-10-18T08:42:51.000000Z",
                            "updated_at": "2023-10-18T08:42:51.000000Z",
                            "deleted_at": null
                        },
                        {
                            "member_type_id": 2,
                            "member_type": "OJT",
                            "created_at": "2023-10-18T08:42:51.000000Z",
                            "updated_at": "2023-10-18T08:42:51.000000Z",
                            "deleted_at": null
                        },
                        {
                            "member_type_id": 3,
                            "member_type": "Development",
                            "created_at": "2023-10-18T08:42:51.000000Z",
                            "updated_at": "2023-10-18T08:42:51.000000Z",
                            "deleted_at": null
                        }
                    ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Get Edit Costs -->
    <tr>
        <td>Costs Page</td>
        <td>/costs/cost/{project_id}</td>
        <td>GET</td>
        <td>Get cost edit data by Id</td>
        <td>
        <pre>
            Request:{ 
            "id": 3
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "id": 3,
                                "jp_cost": 16800,
                                "mm_cost": 0,
                                "actual_cost": 0,
                                "project_id": 1,
                                "created_at": "2023-10-12T07:38:56.000000Z",
                                "updated_at": "2023-10-12T07:38:56.000000Z",
                                "deleted_at": null,
                                "project_name": "new Project"
                            },
                    ]
            }
        </pre>
        </td>
    </tr>
    <!-- For DashBoard -->
    <tr>
        <td>DashBoard Page</td>
        <td>/dashboard</td>
        <td>GET</td>
        <td>Get DashBoard Data</td>
        <td>
        <pre>
            Request:{ 
            "id": 3
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": [
                            {
                                "totalProjects": 53,
                                "currentProjects": 5,
                                "customerCount": 114,
                                "employeeCount": 377
                            },
                    ]
            }
        </pre>
        </td>
    </tr>
    <!-- For Register -->
    <tr>
        <td>Register Page</td>
        <td>/auth/register</td>
        <td>POST</td>
        <td>Create Register</td>
        <td>
        <pre>
            Request:{
                "name": "mg mg",
                "email": "mgmg@gmail.com",
                "password": "123" 
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Login -->
    <tr>
        <td>Login Page</td>
        <td>/auth/login</td>
        <td>POST</td>
        <td>Login</td>
        <td>
        <pre>
            Request:{
                "email": "mgmg@gmail.com",
                "password": "123" 
            }
        </pre>
        </td>
        <td>
        <pre>
            {
                "meta": {
                    "status": 200,
                    "msg": "Success"
                },
                "data": []
            }
        </pre>
        </td>
    </tr>
    <!-- For Home Page -->
    <tr>
    <td>Home Page</td>
    <td>/dashboard</td>
    <td>GET</td>
    <td>Get Emp, Cust and project data</td>
    <td>  Request:{} </td>
    <td> 
    <pre>
    {
                "meta": {
                "status": 200,
                "msg": "Success"
                        },
                        "data": {
                            "totalProjects": 5,
                            "currentProjects": 2,
                            "customerCount": 114,
                            "employeeCount": 378,
                            "Mem_SES": 1,
                            "Mem_Offshore_Mya": 0,
                            "Mem_Offshore_Jan": 1,
                            "Mem_Unassign": 376
                        }
            }  
    </pre>
    </td>
    </tr>
</table>
