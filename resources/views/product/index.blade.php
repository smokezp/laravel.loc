@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All products</div>
                    <table>
                        <thead>
                        <tr>
                            <td>Id</td>
                            <td>Name</td>
                            <td>Size</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->size}}</td>
                            <td><a href="{{route('product.edit', $product->id)}}" class="btn btn-primary">Edit</a></td>
                            <td>
                                <form action="{{route('product.destroy', $product->id)}}" method="POST">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    {{--<input type="hidden" name="id" value="{{$product->id}}" />--}}
                                    <input type="submit" class="btn btn-danger" value="Delete">
                                </form>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="card-body">

                        <a href="{{route('product.create')}}" class="btn btn-primary float-right">
                            {{ __('Create') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
