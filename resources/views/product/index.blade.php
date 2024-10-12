<!doctype html>
<html data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset("twbs/bootstrap/dist/css/bootstrap.min.css") }}">
</head>
<body>
  <main class="container-md  mt-5">
    <h1 class="h1 text-center">{{ $tittle }}</h1>
    <div class="mt-5">
        <table class="table shadow-lg">
            <a class="m-2 float-end" href="{{ route('product.save') }}">
                <button class="btn btn-success ">
                Add
            </button>
            </a>
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                       <td>
                        @if ($product->image)
                            <img width="50" height="50" src="{{ asset('storage/' . $product->image) }}" alt="">
                        @else
                            <img src="" alt="">
                         @endif
                        </td>
                        <td class="align-middle">{{ $product->name }}</td>
                        <td class="align-middle">{{ $product->sku }}</td>
                        <td class="align-middle">{{ $product->price }}</td>
                        <td class="align-middle">
                            <div class="d-flex gap-2">
                                <a href="/product/{{ $product->id }}/edit">
                                    <button class="btn btn-warning btn-sm">
                                        Update
                                    </button>
                                </a>
                                <form action="{{ route('product.delete',$product->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                
                                <a href="/product/{{ $product->id }}/delete">
                                    <button class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </a>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </main>
</body>
</html>