<!-- Navbar-->
      <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
      <header class="bg-light shadow-sm navbar-sticky">
        <div class="navbar navbar-expand-lg navbar-light">
          <div class="container">
            <a class="navbar-brand d-none d-sm-block me-4 order-lg-1" href="."><img src="img/logo-dark.png" width="142" alt="Sales Order"></a><a class="navbar-brand d-sm-none me-2 order-lg-1" href="."><img src="img/logo-icon.png" width="74" alt="Sales Order"></a>
            <div class="navbar-toolbar d-flex align-items-center order-lg-3">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"><span class="navbar-toggler-icon"></span></button><a class="btn btn-primary btn-shadow" href="logout.php">Log Out</a>
            </div>
            <div class="collapse navbar-collapse me-auto order-lg-2" id="navbarCollapse">
              <hr class="my-3">
              <!-- Primary menu-->
              <ul class="navbar-nav">
                <li>
                  <a class="nav-link" href=".">Home</a>
                </li>
                <li>
                  <a class="nav-link" href="./item.php">New Item</a>
                </li>
                <li>
                  <a class="nav-link" href="./customer.php">New Customer</a>
                </li>
                <li>
                  <a class="nav-link" href="./department.php">New Department</a>
                </li>
                <li>
                  <a class="nav-link" href="./staff.php">New Staff</a>
                </li>
                <li>
                  <a class="nav-link" href="./salesorderform.php">New Order</a>
                </li>
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Reports</a>
                  <ul class="dropdown-menu">
                  <li>
                      <a class="dropdown-item" href="itemlist.php">
                        <div class="d-flex">
                          <div class="ms-2"><span class="d-block text-heading">Item List</span></div>
                        </div>
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="salesorderlist.php">
                        <div class="d-flex">
                          <div class="ms-2"><span class="d-block text-heading">Sales Order List</span></div>
                        </div>
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="invoicelist.php">
                        <div class="d-flex">
                          <div class="ms-2"><span class="d-block text-heading">Invoice List</span></div>
                        </div>
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="customerlist.php">
                        <div class="d-flex">
                          <div class="ms-2"><span class="d-block text-heading">Customer List</span></div>
                        </div>
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="carrierlist.php">
                        <div class="d-flex">
                          <div class="ms-2"><span class="d-block text-heading">Carrier List</span></div>
                        </div>
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="departmentlist.php">
                        <div class="d-flex">
                          <div class="ms-2"><span class="d-block text-heading">Department List</span></div>
                        </div>
                      </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="stafflist.php">
                        <div class="d-flex">
                          <div class="ms-2"><span class="d-block text-heading">Staff List</span></div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </header>