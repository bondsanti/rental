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
                      <a href="{{ route('main') }}" class="nav-link {{ request()->routeIs('main') ? 'active' : '' }}">
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
                              ค้นหาห้องเช่า
                          </p>
                      </a>
                  </li>
                  <li class="nav-item {{ request()->routeIs('contract.room') ? 'menu-open' : '' }} {{ request()->routeIs('contract') ? 'menu-open' : '' }} {{ request()->routeIs('out_contract') ? 'menu-open' : '' }} {{ request()->routeIs('contract.list') ? 'menu-open' : '' }} ">
                      <a style="" href="" class="nav-link {{route('contract.room')}}" class="nav-link {{ request()->routeIs('contract.room') ? 'active' : '' }} {{ request()->routeIs('contract.search') ? 'active' : '' }} {{ request()->routeIs('contract') ? 'active' : '' }} {{ request()->routeIs('out_contract') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-layer-group"></i>
                          <p>
                              เอกสารสัญญาเช่าทั้งหมด
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a style="" href="{{route('contract.room')}}" class="nav-link {{ request()->routeIs('contract.room') ? 'active' : '' }} {{ request()->routeIs('contract.search') ? 'active' : '' }}">
                                &nbsp;&nbsp;
                                <i class="nav-icon"> - </i>
                                  <p>
                                      สัญญาห้องเช่า
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a style="" href="{{route('contract.list')}}" class="nav-link {{ request()->routeIs('contract.list') ? 'active' : '' }} {{ request()->routeIs('list.search') ? 'active' : '' }}">
                                &nbsp;&nbsp;
                                <i class="nav-icon"> - </i>
                                  <p>
                                      ทะเบียนสัญญา
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a style="" href="{{ route('contract') }}"
                                  class="nav-link {{ request()->routeIs('contract') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      Code สัญญา
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a style="" href="{{ route('out_contract') }}"
                                  class="nav-link {{ request()->routeIs('out_contract') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      รายงานโครงการ (ออกสัญญา)
                                  </p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a style="" href="" class="nav-link">
                          <i class="nav-icon fa-solid fa-money-bill-trend-up"></i>
                          <p>
                              สรุปรายงานค่าเช่า
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a style="" href="{{ route('report.payment') }}" class="nav-link {{ request()->routeIs('report.payment') ? 'active' : '' }} {{ request()->routeIs('report.payment.search') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      รายงานชำระค่าเช่า
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a style="" href="{{ route('report.guarantee') }}" class="nav-link {{ request()->routeIs('report.guarantee') ? 'active' : '' }} {{ request()->routeIs('report.guarantee.search') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      รายงานชำระค่าการันตี
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a style="" href="{{ route('summary.history') }}" class="nav-link {{ request()->routeIs('summary.history') ? 'active' : '' }} {{ request()->routeIs('summary.history.search') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      สรุปค่าเช่า-การันตี
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a style="" href="{{ route('report.rent') }}" class="nav-link {{ request()->routeIs('report.rent') ? 'active' : '' }} {{ request()->routeIs('report.rent.search') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      สรุปค่าเช่าของห้องเช่า
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a style="" href="{{ route('summary.booking') }}" class="nav-link {{ request()->routeIs('summary.booking') ? 'active' : '' }} {{ request()->routeIs('summary.booking.search') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      สรุปค่าจอง/ค่าประกัน(ห้องเช่า)
                                  </p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item {{ request()->routeIs('report.room') ? 'menu-open' : '' }} {{ request()->routeIs('report.rental') ? 'menu-open' : '' }} {{ request()->routeIs('report.search') ? 'menu-open' : '' }} {{ request()->routeIs('report.availble') ? 'menu-open' : '' }} {{ request()->routeIs('report.asset') ? 'menu-open' : '' }} {{ request()->routeIs('report.asset.search') ? 'menu-open' : '' }}">
                      <a style="" href="" class="nav-link {{ request()->routeIs('report.room') ? 'active' : '' }} {{ request()->routeIs('report.rental') ? 'active' : '' }} {{ request()->routeIs('report.search') ? 'active' : '' }} {{ request()->routeIs('report.availble') ? 'active' : '' }} {{ request()->routeIs('report.asset') ? 'active' : '' }} {{ request()->routeIs('report.asset.search') ? 'active' : '' }}">
                          <i class="nav-icon fa-regular fa-rectangle-list"></i>
                          <p>
                              สรุปรายงานห้องเช่า
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a style="" href="{{ route('report.room') }}" class="nav-link {{ request()->routeIs('report.room') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      รายงานห้องเช่า
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a style="" href="{{ route('report.rental') }}" class="nav-link {{ request()->routeIs('report.rental') ? 'active' : '' }} {{ request()->routeIs('report.search') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      SummaryRental
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a style="" href="{{ route('report.availble') }}" class="nav-link {{ request()->routeIs('report.availble') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      AvailableRoom
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a style="" href="{{ route('report.asset') }}" class="nav-link {{ request()->routeIs('report.asset') ? 'active' : '' }} {{ request()->routeIs('report.asset.search') ? 'active' : '' }}">
                                  &nbsp;&nbsp;
                                  <i class="nav-icon"> - </i>
                                  <p>
                                      Assetห้องเช่า
                                  </p>
                              </a>
                          </li>
                      </ul>
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
