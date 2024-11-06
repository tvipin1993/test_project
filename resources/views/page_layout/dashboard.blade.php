 @php
     $role = 'visiter';
     if (Cookie::get('user_details')) {
         $user_now = json_decode(Cookie::get('user_details'));
         $role = $user_now->role == 1 ? 'admin' : 'customer';
     }
 @endphp
 @extends('page_layout.page_layout')
 @section('title')
     {{ ucwords($role) }} Dashboard
 @endsection

 @section('bodypart')
     <!----------- Header Section ------------------>

     <div class="my_header bg-primary text-white">
         @if ($role == 'visiter')
             <a href="#" class="logo"> Welcome to JWT User Role Management by Vipin </a>
             <div class="my_header-right">
                 <a href="{{ route('logout') }}">Admin Login</i></a>
             </div>
         @else
             <a href="#" class="logo"> {{ ucwords($role) }} Dashboard</a>
             <div class="my_header-right">

                 <a href="#"> {{ strtoupper($user_now->name ?? '') }}</a>
                 <a href="{{ route('logout') }}"><i class="fa fa-sign-out" style="font-size:36px"></i></a>
             </div>
         @endif

     </div>
     <!----------- Header Section ends ------------------>
     {{-- ///////////////  Body Starts //////////////////////////// --}}
     <div class="content ">
         @include('alerts.alert')
     </div>

     <!-- Modal -->
     <div class="modal fade" id="messagemodal">
         <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h4 class="modal-title">Hi {{ ucwords($user_now->name) ?? '' }}</h4>

                 </div>
                 <div class="modal-body">
                     Dear {{ $role }}, welcome to test app. nice to meet you
                 </div>
                 <div class="modal-footer">
                     Thank you for your visit
                 </div>
             </div>
         </div>
     </div>
     <script>
         var sessionSuccess = @json(session('success'));

         if (sessionSuccess) {
             var delayMs = 100;

             setTimeout(function() {
                 $('#messagemodal').modal('show');
             }, delayMs);
         }
     </script>
     {{-- ///////////////  Body Ends //////////////////////////// --}}
 @endsection
