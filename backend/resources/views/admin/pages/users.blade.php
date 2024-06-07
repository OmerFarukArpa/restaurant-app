@extends('admin.layouts.app')

@section('title')
    Kullanıcılar
@endsection

@section('css')
@endsection

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row ">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Kullanıcılar</h4>
                            <form id="form_change_status" action="{{route(('user_change_status'))}}" method="POST">
                                @csrf
                                <input type="text" id="id" name="id" class="d-none">
                            </form>
                            <div class="table-responsive">
                                <table class="table mb-4">
                                    <thead>
                                    <tr>
                                        <th>
                                            No
                                        </th>
                                        <th> Ad Soyad</th>
                                        <th> Email </th>
                                        <th>Durum</th>
                                        <th> Rezervasyon Sayısı </th>

                                        <th> İşlemler </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as  $user)
                                        <tr>
                                            <td>{{$loop->index + $users->firstItem()}}</td>
                                            <td>
                                                <span class="pl-2">{{$user->name}}</span>
                                            </td>
                                            <td> {{$user->email}} </td>
                                            <td><a data-user_name="{{$user->name}}" data-id="{{$user->id}}" class="btn-status btn btn-outline-{{$user->status ? 'success' : 'danger'}} btn-fw mr-1">{{$user->status ? 'Aktif' : 'Pasif'}}</a></td>
                                            <td> {{count($user->reservations)}} </td>
                                            <td>
                                                <a data-id="{{$user->id}}" id="detail" class="btn btn-outline-primary btn-fw mr-1 btn-detail btn-modal">Detay</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                {{$users->links()}}
                                <div data-id="detail" id="myModal" class="modal">

                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h4 id="detail_head" class="mb-4 text-white d-inline-block"></h4>
                                            <span class="modal-close">&times;</span>
                                        </div>
                                        <div id="detail_container">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const form = $('#form_change_status');

        $('.btn-status').click(function (){
            const userId = $(this).data('id');
            form.find('#id').val(userId);
            form.submit();

        })

        $('.btn-detail').click(function (){
            const userId = $(this).data('id');
            console.log(userId)
            $.ajax({
                type: 'get',
                url: '{!! route('user_detail') !!}',
                data: {
                    id: userId
                },
                dataType: "json",
                success: function (user) {
                    $('#detail_head').html(user.name + ' Detay')

                    $('#detail_container').html(`
                                <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 180px'>Ad Soyad :</span>  <span >${user.name}</span>  </div>
                                <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 180px'>Kullanıcı adı :</span>  <span >${user.user_name}</span>  </div>
                                <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 180px'>Email :</span>  <span >${user.email}</span>  </div>
                                <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 180px'>Durum :</span>  <span >${user.status ? 'Aktif' : 'Pasif'}</span>  </div>
                                <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 180px'>Rezervasyon sayısı :</span>  <span >${user.reservations.length || 0}</span>  </div>
                            `)
                },
                error: function (data) {
                    Swal.fire({
                        icon: "error",
                        title: 'Hata',
                        html: "<div id=\"validation-errors\"></div>",
                        showConfirmButton: true,
                        confirmButtonText: "Tamam"
                    });
                    $.each(data.responseJSON.errors, function (key, value) {
                        $('#validation-errors').append('<div class="alert alert-danger">' + value + '</div>');
                    });
                }
            });

        })

    </script>
    <script>
        @if(session('message'))
            Swal.fire({
                icon: 'success',
                title: 'Başarılı!',
                html: '{!! session('message') !!}',
                confirmButtonText: 'Tamam'
            });
        @endif
    </script>
@endsection
