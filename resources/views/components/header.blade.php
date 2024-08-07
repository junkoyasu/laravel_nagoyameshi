<nav class="navbar navbar-expand-md navbar-light shadow-sm nagoyameshi-header-container">
   <div class="container">
     <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{ asset('img/logo.svg')}}" class="img-logo">
       {{ config('app.name', 'Laravel') }}
     </a>
     
     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
       <span class="navbar-toggler-icon"></span>
     </button>
 
     <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <!-- Right Side Of Navbar -->
       <ul class="navbar-nav ms-auto mr-5 mt-2">
         <!-- Authentication Links -->
         @guest
         <li class="nav-item mr-5">
           <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
         </li>
         <li class="nav-item mr-5">
           <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
         </li>
         <hr>
         <li class="nav-item mr-5">
           <a class="nav-link" href="{{ route('login') }}"><i class="far fa-heart"></i></a>
         </li>
        
         @else
         <li class="nav-item mr-5">
           <a class="nav-link" href="{{ route('mypage') }}">
             <i class="fas fa-user mr-5"></i><label>マイページ</label>
           </a>
         </li>
         <li class="nav-item mr-5">
          
           <a class="nav-link" href="{{ route('mypage.favorite') }}">
           @if(Auth::check() && Auth::user()->token)
           <i class="far fa-heart"></i><label>お気に入り</label> 
                        @else
                         <a href="{{ route('mypage.register_card') }}">有料会員の方はお気に入りが確認できます。</a>
                        @endif
            
           <!-- <i class="far fa-heart"></i> -->
           </a>
         </li>
         @endguest
       </ul>
     </div>
   </div>
 </nav>
