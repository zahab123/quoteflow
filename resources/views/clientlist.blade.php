<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="/client"> Add clients</a>
    <h1> Clients list</h1>
    <table style= "border-collapse: collapse; border : 1px solid black;">
         @crfc
    <thead>
           
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Company</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Address</td>
                <td>Notes</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $clients)
            <tr>
                <td>{{$clients->id}}</td>
                <td>{{$clients->name}}</td>
                <td>{{$clients->company}}</td>
                <td>{{$clients->email}}</td>
                <td>{{$clients->phone}}</td>
                <td>{{$clients->address}}</td>
                <td>{{$clients->notes}}</td>
                
                <td>
                    
                    <a href="{{route('deleteclient',$clients->id)}}" >Delete</a>
                    <a href="{{route('updateclient',$clients->id)}}" >Update</a>
                </td>   
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>