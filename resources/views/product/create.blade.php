@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{isset($product) ? 'Edit' : 'Create' }} product</div>

                    <div class="card-body">
                        <div class="form-group row">


                            <div class="col-md-6">
                                <form
                                    action="{{isset($product) ? route('product.update', $product->id):route('product.store')}}"
                                    method="POST">
                                    @csrf
                                    @if(isset($product))
                                        {{ method_field('PATCH') }}
                                    @endif
                                    <label for="email"
                                           class="col-sm-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    <input type="text"
                                           class="form-control"
                                           name="name" required
                                           @if(isset($product)) value="{{$product->name}}" @endif>

                                    <label for="email"
                                           class="col-sm-4 col-form-label text-md-right">{{ __('Size') }}</label>
                                    <input type="number"
                                           class="form-control"
                                           name="size" required
                                           @if(isset($product)) value="{{$product->size}}" @endif>


                                    <input type="submit" class="btn btn-primary float-right mt-2"
                                           value="{{ isset($product) ? __('Update') : __('Store') }}">
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
