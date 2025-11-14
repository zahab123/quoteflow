<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Add New Client</h4>
        </div>
        <div class="card-body">

            <form action="{{route ('addclient')}}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Client Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter client name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Company</label>
                    <input type="text" name="company" class="form-control" placeholder="Enter company name">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Client email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Client phone number">
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3" placeholder="Client address"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Any additional notes"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Save Client</button>
            </form>
            <a href="/clientlist"> client list</a>
        </div>
    </div>
</div> 
</body>
</html>