<?php
$con=mysqli_connect('localhost','root','','treestructure');
$res=mysqli_query($con,"select * from generation");
$arr=[];
while($row=mysqli_fetch_assoc($res)){
	$arr[$row['id']]['parent']=$row['parent'];
	$arr[$row['id']]['parent_id']=$row['parent_id'];
}
$html='';
function buildTreeView($arr,$parent,$level=0,$prelevel= -1){
	global $html;
	foreach($arr as $id=>$data){
		if($parent==$data['parent_id']){
			if($level>$prelevel){
				if($html==''){
					$html.='<ul class="nav navbar-nav">';
				}else{
					$html.='<ul class="dropdown-menu">';
				}
				
			}
			if($level==$prelevel){
				$html.='</li>';
			}
			$html.='<li><a href="#">'.$data['parent'].'<span class="caret"></span></a>';
			if($level>$prelevel){
				$prelevel=$level;
			}
			$level++;
			buildTreeView($arr,$id,$level,$prelevel);
			$level--;
		}
	}
	if($level==$prelevel){
		$html.='</li></ul>';
	}
	return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Life Generation View</title>
      <link href="css/bootstrap.css" rel="stylesheet">
      <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
      <link id="switcher" href="css/theme-color/default-theme.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
   </head>
   <body>
      <section id="menu">
         <div class="container">
            <div class="menu-area">
               <!-- Navbar -->
               <div class="navbar navbar-default" role="navigation">
                  <div class="navbar-header">
                     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                     <span class="sr-only">Generation</span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     </button>          
                  </div>
                  <div class="navbar-collapse collapse">
                     <?php 
					 echo buildTreeView($arr,0);
					 ?>
                  </div>
               
               </div>
            </div>
         </div>
      </section>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="js/bootstrap.js"></script>  
      <script type="text/javascript" src="js/jquery.smartmenus.js"></script>
      <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>  
   </body>
</html>