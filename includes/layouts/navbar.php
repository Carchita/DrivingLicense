
        <!-- Top menu -->
       <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php"><strong><?php if(isset($_SESSION['admin'])) { ?>Admin<?php } ?> Dashboard</strong></a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="top-navbar-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <span class="li-text">
                                Welcome, <?php echo $_SESSION['FirstName'] ; ?>
                            </span> 
                            
                            <span class="li-text">
                                 &nbsp; &nbsp; &nbsp; <a href="<?php if(isset($_SESSION['admin'])) { ?>admin<?php }; ?>logout.php?logout"><strong>Logout</strong></a>
                            </span> 
                            
                        </li>
                    </ul>
                </div>
            </div>
        </nav>