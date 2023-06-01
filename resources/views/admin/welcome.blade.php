

@extends('admin.layout');
@section('styles')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
    }

    .container {
        text-align: center;
        margin-top: 200px;
    }

    h1 {
        color: #333333;
    }
</style>
@endsection
@section('content')
<main id="main" class="main" >
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <div class="container" style="margin-bottom: 200px;">
                            <h1>Chào mừng đến trang quản trị CANIFA!</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

@endsection