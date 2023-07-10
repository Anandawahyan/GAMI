@extends('layouts.customer_app')

@section('title', 'GAMI')

@push('style')
<!-- Template CSS -->
<link rel="stylesheet"
href="{{ asset('css/components.css') }}">
@endpush
<meta name="csrf-token" content="{{ csrf_token() }}" />

@section('main')
<div class="main-content">
    <section class="section my-4">
        <div class="container section-body">

            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-6 col-lg-6">
                    <div class="card chat-box"
                        id="mychatbox" style="min-height: 80vh">
                        <div class="card-header">
                            <h4>Find your style with ChatBot</h4>
                        </div>
                        <div class="card-body chat-content">
                        </div>
                        <div class="card-footer chat-form">
                            <form id="chat-form" method="POST">
                                @csrf
                                <input id="textInput" type="text"
                                    class="form-control"
                                    placeholder="Type a message">
                                <button class="btn btn-primary">
                                    <i class="far fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('library/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
var chats = [
    {
        text: "Halo, Chatbox GAMI adalah chatbox yang berguna sebagai sarana rekomendasi baju untuk kamu",
        position: "left",
    },
    {
        text: "Mulai percakapan langsung dengan memberi pertanyaan seperti 'Halo saya ingin baju yang cocok untuk wanita 20 tahun yang suka bunga'",
        position: "left",
    },
];
for (var i = 0; i < chats.length; i++) {
    var type = "text";
    if (chats[i].typing != undefined) type = "typing";
    $.chatCtrl("#mychatbox", {
        text: chats[i].text != undefined ? chats[i].text : "",
        picture:
            chats[i].position == "left"
                ? "/img/avatar/avatar-1.png"
                : "/img/avatar/avatar-2.png",
        position: "chat-" + chats[i].position,
        type: type,
    });
}

$("#chat-form").on('submit', function (e) {
    e.preventDefault();
    var me = $(this);
    let chatInput = me.find("#textInput").val();

    if (me.find("input").val().trim().length > 0) {
        $.chatCtrl("#mychatbox", {
            text: me.find("#textInput").val(),
            picture: "/img/avatar/avatar-2.png",
        });
        $.chatCtrl("#mychatbox", {
            picture: "/img/avatar/avatar-1.png",
            position: 'left',
            type: 'typing'
        });
        me.find("#textInput").val("");

        $.ajax({
        url: '/gpt',
        type: 'POST',
        dataType: 'json',
        data: {chatInput: chatInput},
        success: function(response) {
            $('.chat-content').html(null);
            chats.push({
                text: chatInput,
                picture: "/img/avatar/avatar-2.png",
                position: 'right'
            }, {
                text: response.choices[0].text,
                picture: "/img/avatar/avatar-2.png",
                position: "left"
            });

            for (var i = 0; i < chats.length; i++) {
                var type = "text";
                if (chats[i].typing != undefined) type = "typing";
                $.chatCtrl("#mychatbox", {
                    text: chats[i].text != undefined ? chats[i].text : "",
                    picture:
                chats[i].position == "left"
                    ? "/img/avatar/avatar-1.png"
                    : "/img/avatar/avatar-2.png",
                position: "chat-" + chats[i].position,
                type: type,
            });
}
        },
        error: function(err) {
            console.log(err);
            console.log(err.responseText);
        }
    })
    }

    
    return false;
});

$('#test').on('click', function() {
    $.ajax({
        url: '/gpt',
        type: 'POST',
        dataType: 'json',
        data: {chatInput: 'Halo saya ingin baju yang cocok untuk wanita 20 tahun yang suka bunga'},
        success: function(response) {
            console.log(response);
        },
        error: function(err) {
            console.log(err);
            console.log(err.responseText);
        }
    })
})
</script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
{{-- <script src="{{ asset('js/page/components-chat-box.js') }}"></script> --}}
@endpush