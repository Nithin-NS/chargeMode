<div class="site-menubar">
  <div class="site-menubar-body">
    <div>
      <div>
            <ul class="site-menu" data-plugin="menu">
              <li class="site-menu-item" data-prefix="">
              	<a class="animsition-link" href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-tachometer" aria-hidden="true"></i>
                     <span class="site-menu-title" style="margin-left: 10px;">
                     	Dashboard
                     </span>              
                    <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item" data-prefix="">
              	<a class="animsition-link" href="{{ url('/connector') }}">
                    <i class="fa fa-plug" aria-hidden="true"></i>
                     <span class="site-menu-title" style="margin-left: 10px;">
                     	Connector Type
                     </span>              
                    <span class="site-menu-arrow"></span>
                </a>
              </li>
              <!-- <li class="site-menu-item" data-prefix="">
              	<a class="animsition-link" href="{{ url('/stations') }}">
                    <i class="fa fa-microchip" aria-hidden="true"></i>
                     <span class="site-menu-title" style="margin-left: 10px;">
                     	Stations
                     </span>              
                    <span class="site-menu-arrow"></span>
                </a>
              </li> -->
              <li class="site-menu-item" data-prefix="">
              	<a class="animsition-link" href="{{ url('/CP') }}">
                    <i class="fa fa-microchip" aria-hidden="true"></i>
                     <span class="site-menu-title" style="margin-left: 10px;">
                     	Charge Point
                     </span>              
                    <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item" data-prefix="">
              	<a class="animsition-link" href="{{ url('/transaction') }}">
                    <i class="fa fa-list" aria-hidden="true"></i>
                     <span class="site-menu-title" style="margin-left: 10px;">
                     	Charging Activity
                     </span>              
                    <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item" data-prefix="">
              	<a class="animsition-link" href="{{ url('/customer') }}">
                    <i class="fa fa-users" aria-hidden="true"></i>
                     <span class="site-menu-title" style="margin-left: 10px;">
                     	Users
                     </span>              
                    <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item" data-prefix="">
              	<a class="animsition-link" href="{{ url('/messages') }}">
                    <i class="fa fa-users" aria-hidden="true"></i>
                     <span class="site-menu-title" style="margin-left: 10px;">
                     	Device Messages
                     </span>              
                    <span class="site-menu-arrow"></span>
                </a>
              </li>
              <li class="site-menu-item" data-prefix="">
              	<a class="animsition-link" >
                    <i class="fa fa-cogs" aria-hidden="true"></i>
                     <span class="site-menu-title" style="margin-left: 10px;">
                     	Settings
                     </span>         
                     <span class="site-menu-arrow"></span>
                </a>
              </li>
            </ul>
          </div>
       </div>
    </div>
  </div>