<?php
//defined( 'SOBIPRO' ) || exit( 'Restricted access' );
define('_JEXEC', 1);
require_once('components/com_sobipro/lib/models/model_controls.php');
$rootdir = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));

if (!defined('_JDEFINES')) {
 //define('JPATH_BASE', dirname(__FILE__));
 define('JPATH_BASE', $rootdir);
 require_once JPATH_BASE.'/includes/defines.php';
}
require_once JPATH_BASE.'/includes/framework.php';
// Instantiate the application.
$app = JFactory::getApplication('site');

// Initialise the application.
$app->initialise();

jimport('joomla.application.component.controller');
$et = $_POST['et'];
$uid = JFactory::getUser()->get('id');

?>
<script>
extend = 1;
</script>
<script>
	dragid_list = '';
  $(function() {
  	$( ".box-sortable" ).sortable({
      revert: true
    });
    $( ".list_type" ).draggable({
		drag: function(event, ui) {
			dragid_list = this.id;
		},
		connectToSortable: "#sortable",
		  helper: "clone",
		  revert: "invalid"
	});
    $( ".list_type" ).droppable({
      drop: function( event, ui ) {
			getListType(this.id, dragid_list);
      }
    });
  });
  </script>
<?php
	if( !Sobi::My( 'id' ) )
	{
	?>
	<script>
		goLogIn();
	</script>
	<?php
	}
	else
	{		
		
		$checkfor = getListCheck();
        
	?>
        <ul>
         <li class="existting-category-list" onclick="addDeviceType_TolistSelected(this);">                                                
            <img class="box-over img-existing" src="<?php if ($checkfor->icon == "") { echo "images/sobipro/images/location_icon/noimage.png"; } else if (!file_exists($checkfor->icon)) { echo "images/sobipro/images/location_icon/noimage.png"; } else { echo $checkfor->icon; } ?>" />
        	<a class="tittle-existing" style="text-transform: uppercase"><?php echo $checkfor->name; ?></a>
            <br />
            <span class="description-existing" style=""><?php if ($checkfor->description == "") { echo "Description"; } else { echo $checkfor->description; } ?></span>                    	
            <label><input onclick="defautDeviceTypeRadioCheck('.$_POST['event_type'].', \''.JRequest::getVar('lang').'\')" class="icheck default_device_type_val" value="<?php echo $checkfor->id; ?>" type="radio" name="optionsRadios_1"  value="option1"></label>
        </li>
       
    <?php
	$doc = new DOMDocument();
	$doc->load( 'components/com_sobipro/lib/js/extra.xml' );
	$lng = strtoupper(JRequest::getString('lang'));
	$checklng = $doc->getElementsByTagName( "".$lng."" );
	$i = 0;
	foreach ($checklng as $checkLngs):
	$i++;
	endforeach;
	$t = $i;
	if ($t == 0) { $lng2 = "DA"; } else { $lng2 = $lng;}
	$books = $doc->getElementsByTagName( "Extra" );
	foreach( $books as $book )
	{
	$langs = $book->getElementsByTagName( "".$lng2."" );
	foreach ($langs as $lang):
	$value = $book->getAttribute('id');
	
	$titles = $lang->getElementsByTagName( "Extra_Name" );
	$title = $titles->item(0)->nodeValue;
    $dess = $lang->getElementsByTagName( "Extra_description" );
	$des = $dess->item(0)->nodeValue;
    $icons = $lang->getElementsByTagName( "Extra_icon" );
	$icon = $icons->item(0)->nodeValue;
    
    endforeach;
	}
	?>
	<?php 
		$extra = getExtra();
		foreach ($extra as $item):
        
        if($item->xmlid == 0){
            
            $image_src = $item->icon;     //image of user set     
              
        }else{
             if($item->changed == 1){
		          
		           $image_src = $item->icon;  //image of user added by hand
                   
             }else{
                $xmlid = $item->xmlid ;
                /**/ 
                                
            	$doc = new DOMDocument();
            	$doc->load( 'components/com_sobipro/lib/js/extra.xml' );
            	$lng = strtoupper(JRequest::getString('lang'));
            	$checklng = $doc->getElementsByTagName( "".$lng."" );
            	$i = 0;
            	foreach ($checklng as $checkLngs):
            	$i++;
            	endforeach;
            	$t = $i;
            	if ($t == 0) { $lng2 = "DA"; } else { $lng2 = $lng;}
            	$books = $doc->getElementsByTagName( "Extra" );
            	foreach( $books as $book ){
            	   
                	$langs = $book->getElementsByTagName( "".$lng."" );
                	foreach( $langs as $lang ){            	   
         	              
                        $id = $book->getAttribute('id');
                          
                        if($id == $xmlid){
                            
                          $images = $lang->getElementsByTagName( "Extra_icon" );
                		  $image_src = $images->item(0)->nodeValue; 
                          
                        }                      	
                        
                	}
                    
            	}
             }
            
               
            
        }
	?>
       <li class="existting-category-list" onclick="addDeviceType_TolistSelected(this);">                                                
            <img class="box-over img-existing" src="<?php if ($image_src == "") { echo "images/sobipro/images/location_icon/noimage.png"; } else if (!file_exists($image_src)) { echo "images/sobipro/images/location_icon/noimage.png"; } else { echo $image_src; } ?>" />
        	<a class="tittle-existing" style="text-transform: uppercase"><?php echo $item->name; ?></a>
            <br />
            <span class="description-existing" style=""><?php if ($item->description == "") { echo "Description"; } else { echo $item->description; } ?></span>                    	
            <label><input onclick="defautDeviceTypeRadioCheck('.$_POST['event_type'].', \''.JRequest::getVar('lang').'\')" class="icheck default_device_type_val" value="<?php echo $item->id; ?>" type="radio" name="optionsRadios_1"  value="option1"></label>
        </li>
        
	<?php
	endforeach;	}
	?>
    </ul>

  