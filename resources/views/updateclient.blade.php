<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <form action="{{route ('postupdateclient',$clients->id)}}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Client name</label>
                    <input type="text" name="name" class="form-control" value="{{$clients->name}}" >
                </div>

                <div class="mb-3">
                    <label class="form-label">Company</label>
                    <input type="text" name="company" class="form-control" value="{{$clients->company}}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{$clients->email}}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{$clients->phone}}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3" value="{{$clients->address}}"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="3" value="{{$clients->notes}}"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Update Client</button>
            </form>
          
</body>
</html>