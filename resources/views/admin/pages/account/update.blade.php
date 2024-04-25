@extends('admin.layouts.master_admin')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <h2 class="mt-3" style="display: flex;justify-content: space-between"><span>Cập nhật</span></h2>
            <div class="row">
                <div class="col-12">
                    @include('admin.pages.account.form')
                </div>
            </div>
        </div>
    </section>
@stop
