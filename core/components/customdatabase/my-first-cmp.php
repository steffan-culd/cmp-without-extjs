<?php
$customDb = $modx->getService('customdatabase','CustomDatabase',$modx->getOption('customdatabase.core_path',null,$modx->getOption('core_path').'components/customdatabase/').'model/customdatabase/',$scriptProperties);
if (!($customDb instanceof CustomDatabase)) return 'something went wrong here...';


$action=$scriptProperties["action"];
$baseUrl = "?a=".$scriptProperties["a"]."&namespace=customdatabase";



////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
/////////////DELETE


if($action=="delete"){
    
    
	if($product = $modx->getObject("cdbProducts",array("id"=>$scriptProperties["id"]))){
        $product->remove();
    }
		

	
	header("location:".$baseUrl);
}//if($action=="update"){




////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
/////////////UPDATE


if($action=="update"){
    
    
	if(!$product = $modx->getObject("cdbProducts",array("id"=>$scriptProperties["id"]))){
        $product = $modx->newObject("cdbProducts");
        $product->set("createdby",$modx->user->id);
        $product->set("createdon",date("Y-m-d H:i:s"));
    }
		
	$product->fromArray($scriptProperties);
    $product->set("editedon",date("Y-m-d H:i:s"));
    $product->set("editedby",$modx->user->id);
    $product->save();	
	
	header("location:".$baseUrl);
}//if($action=="update"){
	


$content='<link rel="stylesheet" href="../assets/manager/style.css">
        <div class="custom-content">
        <h2>Manage products</h2>';






////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
/////////////EDIT



if($action=="edit"){
    
        $product = $modx->getObject("cdbProducts",array("id"=>$scriptProperties["id"]));
        //die($scriptProperties["id"]);
		$content.='<form name="editForm" action="'.$baseUrl.'" method="post">
					
					<input type="hidden" name="action" value="update"/>
					
					<input type="hidden" name="id" value="'.$product->id.'"/>
					<table>';
    

            
        $content.=$modx->getChunk("managerInputTpl",array("label"=>"Product name *","name"=>"name","value"=>(($product->name)?$product->name:""),"required"=>"required","placeholder"=>"Name")); 
    
        $content.='					
                        <tr valign="top">
							<td>
                                <label>Desciption</label>
                            </td>
							<td>
                                <textarea name="description">'.$product->description.'</textarea>
                            </td>
						</tr>
                        
						<tr>
							<td colspan="2" class="tree-new-plugin">
                                <em>
                                    <button type="submit" class="button"> Save changes</button>
                                </em>
								
							</td>
						</tr>
					</table>
				</form>';
		
	
}//if($action=="edit"){




////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
/////////////LIST


if($action=="" || $action=="list"){
    
    $content.='<a href="'.$baseUrl.'&action=edit&id=0" class="button" style="float:right;">Add one</a><input type="text" placeholder="search" style="width:250px;"/><a href="#" class="button">Go!</a><hr/>';

    $whereARR = array();
   
    //$whereARR = array("code:LIKE"=>"789-78");
    
    //START PAGER
    $total = $modx->getCount("cdbProducts",$whereARR);
    $limit=20;
    $offset=0;
    $pages = ceil($total / $limit);
    
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));
    
    $offset = ($page - 1)  * $limit;
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);
    $prevlink = ($page > 1) ? '<a href="'.$baseUrl.'&page=1" title="First page">&laquo;</a> <a href="'.$baseUrl.'&page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
    
    $nextlink = ($page < $pages) ? '<a href="'.$baseUrl.'&page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="'.$baseUrl.'&page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
    $pager = '<div id="paging"><p>'. $prevlink. ' Page '. $page. ' of '. $pages. ' pages. displaying '. $start. '-'. $end. ' of '. $total. ' results '. $nextlink. ' </p></div>';
    
    
    //END PAGER
    
    $productQuery = $modx->newQuery("cdbProducts");
    $productQuery->where($whereARR);
    $productQuery->limit($limit,$offset);
    
    $products = $modx->getIterator("cdbProducts",$productQuery);
    
    $products->rewind();
    if($products->valid()){
        $content.='<table>
                    <tr>
                        <th>code</th>
                        <th>name</th>
                        <th></th>
                        <th></th>
                    </tr>';
        foreach($products as $product){
            $content.='<tr>
                            <td>'.$product->code.'</td>
                            <td>'.$product->name.'</td>
                            <td><a href="'.$baseUrl.'&action=edit&id='.$product->id.'" class="manage-button icon-gear icon icon-large"></a></td>
                            <td><a href="'.$baseUrl.'&action=delete&id='.$product->id.'" class="manage-button icon-trash-o icon icon-large" onclick="return confirm(\'Are you sure you want to delete this record?\');"></a></td>
                        </tr>';
        }//foreach($products as $product){
        $content.='</table>';
    }//if($products->valid()){
    
    //pagination
    $content.=$pager;
    
    $content.='<hr/><a href="'.$baseUrl.'&action=edit&id=0" class="button" style="float:right;">Add one</a>';
}//end action list


     

$content.='</div>';
return $content;