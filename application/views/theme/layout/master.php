 <!DOCTYPE html>
 <html>
 <head>
     <META HTTP-EQUIV="content-type" CONTENT="text/html; charset=utf-8"/>
	<meta charset="utf-8">
        
        <title><?=isset($title)?$title. ' | ': ''?>RoomYo</title>

        <link rel="stylesheet" type="text/css" href="/public/resources/css/styles_theme.css"/>
        
        <link rel="stylesheet" href="/public/resources/css/jquery-ui-1.8.11.custom.css" />
        <link rel="stylesheet" href="/public/resources/css/jquery.weekcalendar_1.css" />
        
        
        <script src="/public/resources/js/jquery/jquery-1.6.4.min.js" type="text/javascript"></script>
        
        <script type="text/javascript"> 
            var result;
                $(document).ready(function(){
                   
                
                events = <?php echo $event_data;?>
                
                    
                });
        </script> 
        
        <script src="/public/resources/js/jquery/jquery-ui-1.8.11.custom.min.js" type="text/javascript"></script>
        <script src="/public/resources/js/ajaxCalls.js" type="text/javascript"></script>
        <script src="/public/resources/js/jquery/jquery.weekcalendar_1.js" type="text/javascript"></script>
        <script src="/public/resources/js/customCalendar.js" type="text/javascript"></script>
        <script src="/public/resources/js/jquery/password_strength_plugin.js" type="text/javascript"></script>
        
        
 </head>
 <body>
 <div class="TOPBAR">
	<div class="right">
		<ul class="links right">
			<li class="dropdown">
                        <?php if($logged_in == true):?>
			<a href=""><?=ucfirst($this->session->userdata('username'));?><em></em></a>
			<ul class="ulDropdown">
                            <li class="sign_out last"><a href="/user/logout">Abmelden</a></li>
                        </ul>
                        <?php else:?>
                        <a href="#">Anmelden</a>
                        <ul class="ulDropdown" style="width:150px;">
                            <li class="account">
                                <div class="dropper">
                                    <?php echo form_open('user/login');?>
                                        <div class="field user_email">
                                            <div class="label">
                                                <?php echo form_label("Benutzer");?>
                                            </div>
                                            <div class="FORM-text">
                                                <div class="field">
                                                        <?php echo form_input(array('name'        => 'username',
                                                                                    'id'          => 'username',
                                                                                    'value'       => '',
                                                                                    'maxlength'   => '50',
                                                                                    'size'        => '50'));?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field password">
                                            <div class="label">
                                                <?php echo form_label("Passwort");?>
                                            </div>
                                            <div class="FORM-text">
                                                <div class="field">
                                                    <?php echo form_password(array('name'         => 'password',
                                                                                    'id'          => 'password',
                                                                                    'value'       => '',
                                                                                    'maxlength'   => '50',
                                                                                    'size'        => '50'));?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttons">
                                            <?php echo form_submit('submit', 'Login', 'class="button login"');?>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                        <?php endif;?>
			</li>
		</ul>
	</div>
 </div>
 <div class="HEADER">
	<div class="wrapper center">
		<div class="logo">
			<a href="/start">RoomYo</a>			
		</div>
		<div class="navigation" >
			<div class="links left">
				<ul>
					<li class="top_level <?=($this->router->class == "" || $this->router->class=="start")?' selected':''?>"><a href="/start">Startseite</a></li>
                                        <li class="top_level <?=($this->router->class=="veranstaltung")?' selected':''?>"><a href="/veranstaltung">Veranstaltung buchen</a></li>
				</ul>
			</div>
                        <div class="links right">
                            <?php if (isset($auth_menu) && $this->session->userdata('role') == 1):?>
                            <ul>
                            
                            <li class="top_level dropdown <?php echo (strpos($this->router->class,'admin') !== FALSE) ? ' active ' : '' ;?>">
                                <?php if (strpos($this->router->class,'admin') === FALSE):?>
                                <a href="#">Administration<em></em></a>
                                <?php else: 
                                    $current_admin_subject = ucfirst(substr($this->router->class, strpos($this->router->class,'_') + 1,  strlen($this->router->class)));
                                    $current_admin_subject = str_replace('ae', '&auml;', $current_admin_subject);
                                ?>
                                <a href="#"><?php echo $current_admin_subject?> Administration<em></em></a>
                                <?php endif;?>
                                <ul class="ulDropdown">
                                    <?php foreach ($auth_menu as $key => $value):?>
                                    <li><a href="<?=$key?>"><?=$value?></a></li>
                                    <?php endforeach;?>
                                </ul>
                            </li>
                            </ul>
                            <?php endif;?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
 </div>
 
 <div class="clear"></div>
 
 <div class="MAIN">
	<div class="wrapper center">
		<div class="CONTENT">
                    <div class="wrap">
                        <div class="CONTENT_CONTROLS">
                            <div class="TITLE">
                            <h1>
                                    <?=$title?>
                                    <?php if (isset($show_heading_link)):?>
                                    <a class="tiny" href="#">reload page</a>
                                    <?php endif;?>
                            </h1>
                            <div class="filter">
                            </div>
                            </div>
                        </div>
                        <div class="CONTENT_HOST">
                            <?=$this->load->view($this->pages_folder.$content_view, $content_data, TRUE);?>
                        </div>
                    </div>
		</div>
		
            <div class="SIDEBAR">
            
            </div>
                
	</div>
	 <div class="clear"></div>
 </div>
 
 <div class="clear"></div>
 
 <div class="FOOTER">
	<div class="wrapper center">
		&copy; Menzel & Thomer 2011 
	</div>

 </div>

 </body>
 </html>