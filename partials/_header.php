<div class="navbar">
	<div class="navbar-inner">
    	<a class="brand" href="index.php">GBC Mini-Scheduling System</a>
        <?php
            if(isset($_SESSION['admin_user']) || isset($_SESSION['teacher'])){
                echo "<ul class='nav pull-right'>
                        <li><a href='logout.php'><i class='icon-user'></i> Logout</a></li>
                    </ul>";
            }
        ?>
    	
    </div>
</div>
