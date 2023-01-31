@extends('layout')

@section('title')
{{ __("Home") }}
@endsection

@section('content')
<div class="container" id="app">
    <h3 class="mt-3">CT - Laravel Test / Honoré Lata ( <a href="mailto:lkh@honore-lata.com">lkh@honore-lata.com</a> )</h3>

    <br>
    <div class="row">
        <div class="col-md-12">
            <div id="message"></div>
            <form id="save-product">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <strong>Create A New Product</strong>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Product Name" v-model="productName">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity In Stock:</label>
                            <input type="number" class="form-control" name="quantity" placeholder="Quantity" v-model="quantity">
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price per Item:</label>
                            <input type="number" class="form-control" name="price" placeholder="Price per item" v-model="price">
                        </div>

                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>List of Items</strong>
                </div>
                <div class="card-body">
                    <table class="table" id="product-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quantity in stock</th>
                                <th scope="col">Price per item</th>
                                <th scope="col">Date time submitted</th>
                                <th scope="col">Total Value</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                
                            <tr>
                                <th scope="row">{{ $item['count'] }}</th>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ $item['price'] }}</td>
                                <td>{{ $item['submitted'] }}</td>
                                <td>{{ $item['total_value'] }}</td>
                                <td>
                                    <a href="{{route('edit.product', $item['count'])}}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection


@section('scripts')
    <script>
        $("#save-product").submit(function(e) {
            e.preventDefault();
            let form_data = new FormData(this);
            $(document).find("span.invalid-feedback").remove();
            $(document).find("#message").empty();
            $.ajax({
                url: "{{ route('product.new') }}"
                , type: "POST"
                , data: form_data
                , cache: false
                , contentType: false
                , processData: false
                , success: function(response) {
                    $("#message").append('<div class="alert alert-success mt-3 mt-n3 mb-3 text-center h4" role="alert"> <strong>Product Save successfully</strong></div>');
                         $("#product-table").load(window.location.href + " #product-table" );
                }
                , error: function(response) {
                    $.each(response.responseJSON.errors, function(field_name, error) {
                        console.log(field_name)
                        var field = $(document).find('[name=' + field_name + ']')
                        field.addClass('is-invalid')
                        field.after('<span class="invalid-feedback my-1" role="alert"> <strong>' + error + '</strong></span>')
                    })
                }
            })
        })
    </script>

@endsection