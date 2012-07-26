<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Drag Drop Panels - Web Developer Plus Demos</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<script type="text/javascript" src="js/jquery-1.3.2.js" ></script>
<script type="text/javascript" src="js/jquery.json-2.2.min.js" ></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js" ></script>
<script type="text/javascript" >
// MAIN STAGE DRAGGABLE BOXES

$(function(){
	$('.dragbox')
	.each(function(){
		$(this).hover(function(){
			$(this).find('h2').addClass('collapse');
		}, function(){
		$(this).find('h2').removeClass('collapse');
		})
		.find('h2').hover(function(){
			$(this).find('.configure').css('visibility', 'visible');
		}, function(){
			$(this).find('.configure').css('visibility', 'hidden');
		})
		.click(function(){
			$(this).siblings('.dragbox-content').toggle();
			updateWidgetData();
		})
		.end()
		.find('.configure').css('visibility', 'hidden');
	});
    
	$('.column').sortable({
		connectWith: '.column',
		handle: 'h2',
		cursor: 'move',
		placeholder: 'placeholder',
		forcePlaceholderSize: true,
		opacity: 0.4,
		start: function(event, ui){
			//Firefox, Safari/Chrome fire click event after drag is complete, fix for that
			if($.browser.mozilla || $.browser.safari) 
				$(ui.item).find('.dragbox-content').toggle();
		},
		stop: function(event, ui){
			ui.item.css({'top':'0','left':'0'}); //Opera fix
			if(!$.browser.mozilla && !$.browser.safari)
				updateWidgetData();
		}
	})
	.disableSelection();
});

function updateWidgetData(){
	var items=[];
	$('.column').each(function(){
		var columnId=$(this).attr('id');
		$('.dragbox', this).each(function(i){
			var collapsed=0;
			if($(this).find('.dragbox-content').css('display')=="none")
				collapsed=1;
			var item={
				id: $(this).attr('id'),
				collapsed: collapsed,
				order : i,
				column: columnId
			};
			items.push(item);
		});
	});
	var sortorder={ items: items };
			
	//Pass sortorder variable to server using ajax to save state
	$.post('updatePanels.php', 'data='+$.toJSON(sortorder), function(response){
		if(response=="success")
			$("#console").html('<div class="success">Saved</div>').hide().fadeIn(1000);
		setTimeout(function(){
			$('#console').fadeOut(1000);
		}, 2000);
	});
}
</script>
</head>
<body>
	<h3>Drag n Drop Panels</h3>
	
	<div id="console" ></div>
	
		<?php
		$dummy="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vestibulum velit ultricies orci pharetra elementum. In massa mauris, varius sed tempus a, iaculis sed erat. Ut sollicitudin tellus mollis arcu laoreet semper. Suspendisse ut felis odio. Aliquam auctor, tortor sit amet suscipit elementum, nunc ante dictum lectus, ac accumsan justo nunc sed velit. Sed sollicitudin varius tortor vitae varius. Aliquam interdum, nisl consectetur laoreet commodo, metus massa sagittis nisl, non venenatis lacus mi nec tortor. Ut malesuada auctor dolor, id pulvinar est malesuada sed. Aliquam sed posuere orci. Proin porttitor euismod condimentum. Integer suscipit nibh nec augue facilisis ut commodo nisi ornare. Nam sed mauris vitae justo convallis placerat. Curabitur viverra, ipsum id volutpat sollicitudin, mi nisi condimentum nulla, nec dapibus velit libero eget orci. Nam purus lectus, imperdiet pharetra pulvinar ac, sodales sit amet sem. Ut vel mollis ante. Vivamus consectetur varius risus eu hendrerit. Sed scelerisque euismod leo, quis accumsan justo venenatis eu. Ut risus lorem, aliquet id fermentum nec, auctor ut enim. Ut pretium elementum turpis vel dignissim.";
		
		include('./config.php');
			
			$columns=mysql_query('SELECT DISTINCT column_id FROM widgets ORDER BY column_id');
			while($column=mysql_fetch_array($columns))
			{
				echo '<div class="column" id="column'.$column['column_id'].'" >';
				$items=mysql_query("SELECT * FROM widgets WHERE column_id='".$column['column_id']."' ORDER BY sort_no");
				while($widget=mysql_fetch_array($items))
				{
					echo '
					<div class="dragbox" id="item'.$widget['id'].'">
						<h2>'.$widget['title'].'</h2>
							<div class="dragbox-content" ';
					if($widget['collapsed']==1)
						echo 'style="display:none;" ';
					echo '>
								'.substr($dummy, 0, rand(120, strlen($dummy))).'
							</div>
					</div>';
				}				
				echo '</div>';
			}
		?>
	
	
	<hr style="clear:both;" />
<p>
Demo Provided By: <a href="http://webdeveloperplus.com" title="Web Developer Plus - Ultimate Web Development & Design Resource" >Web 
Developer Plus</a></p>
</body>
</html>
