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

            <form id="update-product">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <strong>Update a product</strong>
                        <a href="{{route('list.product')}}" class="float-end"> Home</a>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Product Name" value="{{ $product['name'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity In Stock:</label>
                            <input type="number" class="form-control" name="quantity" placeholder="Quantity" value="{{ $product['quantity'] }}">
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price per Item:</label>
                            <input type="number" class="form-control" name="price" placeholder="Price per item" value="{{ $product['price'] }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <br>

</div>
@endsection

@section('scripts')
<script>
    let url = "{{ route('edit.product', $product['count']) }}";
    $("#update-product").submit(function(e) {
        e.preventDefault();
        let form_data = new FormData(this);
        $(document).find("span.invalid-feedback").remove();
        $(document).find("#message").empty();
        $.ajax({
            url: url
            , type: "POST"
            , data: form_data
            , cache: false
            , contentType: false
            , processData: false
            , success: function(response) {
                $("#message").append('<div class="alert alert-success mt-3 mt-n3 mb-3 text-center h4" role="alert"> <strong>Product Update successfully</strong></div>');
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