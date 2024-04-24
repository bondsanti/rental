  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-1 sidebar-dark-lightblue sidebar-gardians">
      <!-- Brand Logo -->
      <a href="{{ route('main') }}" class="brand-link">

              <img src="{{ url('uploads/logo.png') }}" alt="vbeyond" class="brand-image elevation-0" style="opacity: .8">
              <span class="brand-text text-center"> VBEYOND Rental</span>

      </a>



      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">

                  <img src="{{ url('uploads/avatar.png') }}" class="img-circle elevation-2" alt="User Image">

              </div>
              <div class="info">
                  <a href="#" class="d-block">คุณ {{ $dataLoginUser->name_th }}</a>
              </div>
          </div>

              <!-- Sidebar -->
              <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                      data-accordion="false">
                      <li class="nav-item">
                          <a href="{{ route('main') }}"
                              class="nav-link {{ request()->routeIs('main') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-tachometer-alt"></i>
                              <p>
                                  แดชบอร์ด
                                  {{-- <span class="right badge badge-danger">New</span> --}}
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('room') }}"
                            class="nav-link {{ request()->routeIs('room') ? 'active' : '' }} {{ request()->routeIs('room.index') ? 'active' : '' }} ">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                เพิ่มห้องเช่า
                            </p>
                        </a>
                    </li>
                      <li class="nav-item">
                          <a href="{{ route('rental') }}"
                              class="nav-link {{ request()->routeIs('rental') ? 'active' : '' }} {{ request()->routeIs('rental.search') ? 'active' : '' }} {{ request()->routeIs('rental.detail') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-building"></i>
                              <p>
                                  ห้องเช่า
                              </p>
                          </a>
                      </li>
                      <li class="nav-item">
                        {{-- <a style="background-color: rgba(255, 23, 35, 0.486)" href="{{route('logoutUser')}}" class="nav-link {{ request()->routeIs('logoutUser') ? 'active' : '' }}"> --}}
                        <a style="" href="{{ route('logoutUser') }}"
                            class="nav-link {{ request()->routeIs('logoutUser') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sign-out"></i>
                            <p>
                                ออกจากระบบ
                                {{-- <span class="right badge badge-danger">New</span> --}}
                            </p>
                        </a>
                    </li>
                  </ul>
              </nav>







          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
