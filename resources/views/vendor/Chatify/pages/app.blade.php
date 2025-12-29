@php
    use Illuminate\Support\Facades\Auth;

    if (Auth::check()) {
        $role = Auth::user()->role ?? 'customer';
        $layout = $role === 'tailor' ? 'layouts.tailor' : 'layouts.cust';
    } else {
        $layout = 'layouts.app';
    }
@endphp

@extends($layout)

@vite(['resources/css/app.css', 'resources/js/app.js'])


@section('content')

@include('Chatify::layouts.headLinks')
<div class="messenger">
    {{-- ----------------------Users/Groups lists side---------------------- --}}
    <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
        {{-- Header and search bar --}}
        <div class="m-header">
            <nav>
                <a href="#"><i class="fas fa-inbox"></i> <span class="messenger-headTitle">MESSAGES</span> </a>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            {{-- Search input --}}
            <input type="text" class="messenger-search" placeholder="Search" />
            {{-- Tabs --}}
            {{-- <div class="messenger-listView-tabs">
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts</a>
            </div> --}}
        </div>
        {{-- tabs and lists --}}
        <div class="m-body contacts-container">
           {{-- Lists [Users/Group] --}}
           {{-- ---------------- [ User Tab ] ---------------- --}}
           <div class="show messenger-tab users-tab app-scroll" data-view="users">
               {{-- Favorites --}}
               <div class="favorites-section">
                <p class="messenger-title"><span>Favorites</span></p>
                <div class="messenger-favorites app-scroll-hidden"></div>
               </div>
               {{-- Saved Messages --}}
               <p class="messenger-title"><span>Your Space</span></p>
               {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
               {{-- Contact --}}
               <p class="messenger-title"><span>All Messages</span></p>
               <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>
           </div>
             {{-- ---------------- [ Search Tab ] ---------------- --}}
           <div class="messenger-tab search-tab app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title"><span>Search</span></p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
             </div>
        </div>
    </div>

    {{-- ----------------------Messaging side---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="m-header m-header-messaging">
            <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                {{-- header back button, avatar and user name --}}
                <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                    </div>
                    <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="dashboard"><i class="fas fa-home"></i></a>
                    <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                </nav>
            </nav>
            {{-- Internet connection --}}
            <div class="internet-connection">
                <span class="ic-connected">Connected</span>
                <span class="ic-connecting">Connecting...</span>
                <span class="ic-noInternet">No internet access</span>
            </div>
        </div>

        {{-- Messaging area --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
                <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
            </div>
            {{-- Typing indicator --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <div class="message">
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        {{-- Send Message Form --}}
<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
        @csrf
        <label><span class="fas fa-plus-circle"></span><input disabled='disabled' type="file" class="upload-attachment" name="file" accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" /></label>
        <button class="emoji-button"></span><span class="fas fa-smile"></button>
        <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>
        <button disabled='disabled' class="send-button"><span class="fas fa-paper-plane"></span></button>
    </form>
</div>

    </div>
    {{-- ---------------------- Info side ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- nav actions --}}
        <nav>
            <p>User Details</p>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        {!! view('Chatify::layouts.info')->render() !!}
    </div>
</div>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')

<style>
/* ====== Chatify Responsive Custom Style ====== */

/* Pastikan container penuh layar */
.messenger {
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 90vh; /* menyesuaikan tinggi layar */
    max-height: 100vh;
    overflow: hidden;
}

/* Panel kiri (list chat) */
.messenger-listView {
    flex: 1;
    min-width: 280px;
    max-width: 350px;
    background-color: #fff9e6; /* nuansa kuning lembut */
    border-right: 2px solid #fcd34d;
}

/* Panel kanan (chat aktif) */
.messenger-messagingView {
    flex: 3;
    background-color: #fffef8;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Header chat */
.m-header {
    background-color: #facc15;
    color: #000;
    padding: 10px;
}

.m-header a, 
.m-header i {
    color: #000;
}

/* Scroll area */
.app-scroll {
    overflow-y: auto;
    height: 100%;
}

/* Pesan */
.messages-container {
    flex-grow: 1;
    padding: 15px;
    overflow-y: auto;
}

/* Responsif untuk tablet */
@media (max-width: 992px) {
    .messenger {
        flex-direction: column;
    }
    .messenger-listView {
        width: 100%;
        max-width: none;
        border-right: none;
        border-bottom: 2px solid #fcd34d;
    }
    .messenger-messagingView {
        width: 100%;
    }
}

/* Responsif untuk mobile */
@media (max-width: 768px) {
    .messenger {
        height: auto;
        min-height: 100vh;
    }

    .m-header {
        font-size: 14px;
        text-align: center;
    }

    .messenger-listView {
        display: none;
        position: absolute;
        z-index: 100;
        top: 0;
        left: 0;
        height: 100vh;
        background-color: #fff9e6;
    }

    .messenger-listView.conversation-active {
        display: block;
    }

    .messenger-messagingView {
        width: 100%;
        flex: 1;
    }

    .show-listView {
        display: inline-block !important;
    }
}

/* Tambahan warna kuning di beberapa elemen */
.messenger-title span {
    color: #b45309;
    font-weight: 600;
}

.ic-connected {
    color: #22c55e;
}
.ic-noInternet {
    color: #ef4444;
}
</style>


@endsection
