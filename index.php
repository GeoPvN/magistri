<?php session_start(); ?>
<?php require_once(dirname(__FILE__) . '/config.php'); ?>

<?php if ($_SESSION['USERID'] == ''): ?>
	<?php require_once(ABSPATH . 'includes/login.php');?>
<?php else: ?>
	<?php require_once(ABSPATH . 'includes/functions.php');?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>CallApp - Premix</title>

			<link rel="shortcut icon" type="image/ico" href="media/images/CA-mini.png" />
			<link rel="stylesheet" type="text/css" media="screen" href="media/css/reset/reset.css" />
			<!--[if IE]>
				<link rel="stylesheet" type="text/css" media="screen" href="css/reset/ie.css" />
			<![endif]-->

			<?php echo GetJs();?>
			<?php echo GetCss();?>

			<script type="text/javascript">
				$(document).ready(function (){
					AjaxSetup();
				});
			</script>


    <script type="text/javascript">
        $(function(){


            
            $(document).ready(function (){

            	$(document).on("click", ".logout", function () {
	            	$.ajax({
				        url: "server-side/logout.action.php",
					    data: "act=logout_save",
				        success: function(data) {
				        	window.location.href="index.php?act=logout";
					    }
				    });						
		        });
				
			});
        });
        
    </script>

		</head>
		<body>
		<div id="disable_all" style="position: absolute;height: 100%;width: 100%;display: none;"></div>
			<div id="npm"></div>
			<?php require_once(ABSPATH . 'includes/pages.php'); ?>
			
			<div id="newsmain">
			
			</div>
			<div id='yesnoclose' class="form-dialog">
                <div id="dialog-form">
                    <fieldset>
                                                 გსურთ თუ არა ცვლილებების შენახვა?
                    </fieldset>
                </div>
            </div>
            
            <!-- jQuery Dialog -->
            <div  id="play_audio" class="form-dialog" title="მოსმენა">
                <audio controls autoplay>
                  <source src="" type="audio/wav">
                </audio>
            </div>
		</body>
	</html>
<?php endif;?>