<?php
$customDb = $modx->getService('customdatabase','CustomDatabase',$modx->getOption('customdatabase.core_path',null,$modx->getOption('core_path').'components/customdatabase/').'model/customdatabase/',$scriptProperties);
if (!($customDb instanceof CustomDatabase)) return 'something went wrong here...';


$products = $modx->getIterator("cdbProducts");
    
    $products->rewind();
    if($products->valid()){
        $content.='<table width="100%;">
                    <tr>
                        <th>code</th>
                        <th>name</th>
                        
                    </tr>';
        foreach($products as $product){
            $content.='<tr>
                            <td>'.$product->code.'</td>
                            <td>'.$product->name.'</td>
                            
                        </tr>';
        }//foreach($products as $product){
        $content.='</table>';
    }//if($products->valid()){
    
    
return $content;