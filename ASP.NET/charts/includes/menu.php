<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Organized Chaos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" id="navbarDropdown" aria-haspopup="true" aria-expanded="false">Home</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/Home">Homepage</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/Home/About">About</a>
                    <a class="dropdown-item" href="/Home/Contact">Contact us</a>
                    <a class="dropdown-item" href="/SenseHat">Feed</a>
                    <a class="dropdown-item" href="/Home/Features">Features</a>
                  </div>
                </li>


            </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="<?php if($this_page == 'devices') { echo 'active'; }; ?> nav-item"><a class="nav-link" href="/app/devices">Devices</a></li>
                <li class="<?php if($this_page == 'alerts') { echo 'active'; }; ?> nav-item"><a class="nav-link" href="/alerts/">Alerts</a></li>
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" id="navbarDropdown" aria-haspopup="true" aria-expanded="false">Statistics</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="<?php if($this_page == 'realtime') { echo 'active'; }; ?> dropdown-item" href="/real-time/">
                    <svg class="feather feather-activity sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="height: 18px;margin-top: -3px;margin-right: -5px;color: #212529;"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                    Realtime</a>
                    <div class="dropdown-divider"></div>
                    <a class="<?php if($this_page == 'daily') { echo 'active'; }; ?> dropdown-item" href="/charts/">
                    <svg class="feather feather-bar-chart-2 sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="height: 18px;margin-top: -3px;margin-right: -5px;color: #212529;"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                    Daily</a>
                    <a class="<?php if($this_page == 'monthly') { echo 'active'; }; ?> dropdown-item" href="/charts/monthly">
                    <svg class="feather feather-bar-chart-2 sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="height: 18px;margin-top: -3px;margin-right: -5px;color: #212529;"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                    Monthly</a>
                    <div class="dropdown-divider"></div>
                    <a class="<?php if($this_page == 'analysis') { echo 'active'; }; ?> dropdown-item" href="/charts/analysis">
                      <svg class="feather feather-bar-chart sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="height: 18px;margin-top: -3px;margin-right: -5px;color: #212529;"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                    Analysis</a>
                  </div>
                </li>
              </ul>
        </div>
    </div>
</nav><br>