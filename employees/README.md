# Employees Service

This is the employee micro service that composed under the API gateway.

## Logical Design

```
Employees   -> DB
            -> Reddit
```

<table>

</tr>
<!-- For Employee Myanmar -->
<tr>
<td>Engineer List Page</td>
<td>/employees</td>
<td>GET</td>
<td>Get Employees(MM) data</td>
<td>
Request:{
}
</td>
<td><pre>
{
"meta": {
"status": 200,
"msg": "Success"
},
"data": [
{
"id": 9,
"emp_cd": "J0017",
"emp_name": "Hnin Ei Kyu",
"position": "1",
"created_date": "2022-08-22 13:47:40",
"modified_date": "2021-06-01 09:00:00",
"group_cd": "A00",
"gl_flag": "1",
"activation_code": "",
"emp_email": "hnineikyu@gicjp.com",
"location": "Japan"
},
{
"id": 11,
"emp_cd": "J0019",
"emp_name": "Hset Hset Aung",
"position": "1",
"created_date": "2022-08-22 13:47:40",
"modified_date": "2021-02-16 09:00:00",
"group_cd": "G00",
"gl_flag": "1",
"activation_code": "",
"emp_email": "hsethsetaung@gicjp.com",
"location": "Japan"
},
{
"id": 13,
"emp_cd": "J0021",
"emp_name": "Yin Min Theint",
"position": "1",
"created_date": "2022-08-22 13:47:40",
"modified_date": "2021-02-16 09:00:00",
"group_cd": "G00",
"gl_flag": "1",
"activation_code": "",
"emp_email": "yinmintheint@gicjp.com",
"location": "Japan"
}
....
]
}</pre>
</td>
</tr>
<!-- For Filter employees -->
<tr>
<td>Engineer List Page</td>
<td>/employees/search?filter[emp_cd]=employee name</td>
<td>GET</td>
<td>Get Employees(MM) data</td>
<td>
Request:{
}
</td>
<td><pre>
{
    "meta": {
        "status": 200,
        "msg": "Success"
    },
    "data": [
        {
            "id": 278,
            "emp_cd": "201972",
            "emp_name": "Ingyin Phway",
            "position": "3",
            "created_date": "2020-07-02 18:21:03",
            "modified_date": "2020-07-02 18:21:03",
            "group_cd": "G05",
            "gl_flag": null,
            "activation_code": null,
            "emp_email": "ingyinphway@gicjp.biz"
        }
    ]
}</pre>
</td>
</tr>

</table>
