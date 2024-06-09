<?php
use Illuminate\Foundation\Auth;
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="{{asset('user/img/profile/'.auth()->user()->image)}}" alt="profile">
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{auth()->user()->name}}</span>
            <span class="text-secondary text-small">{{auth()->user()->role}}</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/admin_portal">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('customers.index')}}">
          <span class="menu-title">Customer</span>
          <i class="mdi mdi-account menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('memberships.index')}}">
          <span class="menu-title">Membership</span>
          <i class="mdi mdi-account-card-details menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('staffs.all')}}">
          <span class="menu-title">Staff</span>
          <i class="mdi mdi-account-tie menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('products.admin')}}">
          <span class="menu-title">Product</span>
          <i class="mdi mdi-cube-outline menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/payments">
          <span class="menu-title">Payment</span>
          <i class="mdi mdi-coin menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/delivery">
          <span class="menu-title">Delivery</span>
          <i class="mdi mdi-truck-fast menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('comments.index')}}">
          <span class="menu-title">Comment</span>
          <i class="mdi mdi-comment-text-multiple-outline menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/freegifts">
          <span class="menu-title">Free Gift</span>
          <i class="mdi mdi-gift menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/gift-records">
          <span class="menu-title">Gift Record</span>
          <i class="mdi mdi-label menu-icon"></i>
        </a>
      </li>
      <li class="nav-item"> 
        <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
          <span class="menu-title">Reports</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-chart-bar menu-icon"></i>
        </a>
        <div class="collapse" id="general-pages">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('monthlySales')}}"> Monthly Sales </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('userDemographic')}}"> User Demographic </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('commentAnalysis')}}"> Comment Analysis  </a></li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>