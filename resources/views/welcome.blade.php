<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Document</title>
    
</head>
<body>
    <div class="container-fluid min-vh-100" 
         style="background-image: url('{{ asset('storage/products/Types.jpg') }}'); background-size: cover; background-position: center;">

        <div class="d-flex justify-content-between align-items-center p-3">
    
    <div class="d-flex align-items-center">
        <img src="{{ asset('storage/products/logoz.jpg') }}" 
             alt="Logo" 
             class="rounded-circle border border-white" 
             style="width: 60px; height: 60px; object-fit: cover; box-shadow: 0px 4px 8px rgba(0,0,0,0.2);">
        
        <span class="ms-3 fw-bold text-white fs-3" 
              style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5); font-family: 'Roboto', sans-serif;">
            PrimeCart
        </span>
    </div>

    <div>
        <a href="{{ route('login') }}" class="btn btn-light shadow px-4">Login</a>
    </div>

</div>
     
    </div>



{{-- “Shop Smarter with Prime Cart.”
Discover amazing deals, trusted products, and a shopping experience made simple. --}}
</body>
</html>