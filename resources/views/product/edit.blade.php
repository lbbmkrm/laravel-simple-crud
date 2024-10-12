<!doctype html>
<html data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('twbs/bootstrap/dist/css/bootstrap.min.css') }}">
</head>
<body>
  <main class="container mt-5">
    <div class="my-5 mx-auto card border-0 shadow-lg">
        <a href="{{ route('product.index') }}" class="m-3">
            <button class="btn btn-success">Home</button>
        </a>
        <div class="mx-auto my-2 border-0">
            <h3 class="h3">Update a product</h3>
        </div>
        <form class="card-body" method="POST" enctype="multipart/form-data" action="{{ route('product.update',$product->id) }}">
            @method('PUT')
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label ms-2">Name</label>
              <input type="text" name="name" class="@error('name') is-invalid @enderror form-control form-control-lg" id="name" placeholder="Product Name" value="{{ old('name',$product->name) }}">
              @error('name')
                  <p class="invalid-feedback">Name is required</p>
              @enderror
            </div>
            <div class="mb-3">
              <label for="sku" class="form-label ms-2">SKU</label>
              <input type="text" name="sku" class="@error('sku') is-invalid @enderror form-control form-control-lg" id="sku" placeholder="Product SKU" value="{{ old('sku',$product->sku) }}">
              @error('sku')
                  <p class="invalid-feedback">SKU is required</p>
              @enderror
            </div>
            <div class="mb-3">
              <label for="price" class="form-label ms-2">Price</label>
              <input type="text" name="price" class="@error('price') is-invalid @enderror form-control form-control-lg" id="price" placeholder="Product Price" value="{{ old('price',$product->price) }}">
              @error('price')
                  <p class="invalid-feedback">Price is required</p>
              @enderror
            </div>
            <div class="mb-3">
              <label for="description" class="form-label ms-2">Description</label>
              <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label ms-2">Image</label>
              <input type="file" name="image" class="form-control form-control-lg" id="image">
            </div>
            <button type="submit" class="btn btn-primary w-100 p-2">Submit</button>
        </form>
    </div>
  </main>
</body>
</html>
