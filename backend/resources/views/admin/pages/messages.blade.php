@extends('admin.layouts.app')

@section('title')
    Mesajlar
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
                            <h4 class="card-title">Mesajlar</h4>
                            <div class="table-responsive">
                                <table class="table mb-4">
                                    <thead>
                                    <tr>
                                        <th>
                                            No
                                        </th>
                                        <th> Ad Soyad </th>
                                        <th> Email </th>
                                        <th> Konu </th>
                                        <th>Durum</th>
                                        <th>Tarih</th>
                                        <th> İşlemler </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($messages as $message)
                                        <tr>
                                            <td>{{$loop->index + $messages->firstItem()}}</td>
                                            <td>
                                                <span class="pl-2">{{$message->user->name}}</span>
                                            </td>
                                            <td> {{$message->user->email}}</td>
                                            <td> {{$message->topic->name}} </td>
                                            <td><i class="mdi mdi-email icon-md {{!$message->read_at ? 'message-icon' : 'text-danger'}}"></i></td>
                                            <td> {{$message->created_at}} </td>
                                            <td>
                                                <a data-read_at="{{$message->read_at}}" data-id="{{$message->id}}" id="detail" class="btn btn-outline-primary btn-fw mr-1 btn-detail btn-modal">Göster</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$messages->links()}}
                                <div data-id="detail" id="myModal" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h4 id="detail_head" class="mb-4 text-white d-inline-block"></h4>
                                            <span id="message_detail_close" class="modal-close">&times;</span>
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
        $('.btn-detail').click(function (){
            $('#detail_head').html('');
            $('#detail_container').html('');
            const messageId = $(this).data('id');
            const readAt = $(this).data('read_at');
            $.ajax({
                type: 'get',
                url: '{!! route('message_detail') !!}',
                data: {
                    id: messageId
                },
                dataType: "json",
                success: function (message) {
                    $('#detail_head').html(message.topic.name + ' Mesajı')

                    $('#detail_container').html(`
                                <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 18%'>Ad Soyad :</span>  <span  style='flex:1;text-wrap: wrap;word-break: break-word'>${message.user.name}</span>  </div>
                                <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 18%'>Email :</span>  <span  style='flex:1;text-wrap: wrap;word-break: break-word'>${message.user.email}</span>  </div>
                                <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 18%'>Konu :</span>  <span  style='flex:1;text-wrap: wrap;word-break: break-word'>${message.topic.name}</span>  </div>
                                <div class="mb-4 d-flex"><span class="font-weight-bold text-white" style='width: 18%'>Mesaj :</span>  <span style='flex:1;text-wrap: wrap;word-break: break-word' >${message.message}</span>  </div>
                            `)

                        $(document).click(function (e){
                            if(e.target.closest('message_detail_close') || (e.target != $('#myModal').find('.modal-content'))){
                                if(readAt == '0'){
                                    window.location.reload();
                                }
                            }
                        })

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
@endsection
