<?php
die("fuck off");
$customDb = $modx->getService('customdatabase','CustomDatabase',$modx->getOption('customdatabase.core_path',null,$modx->getOption('core_path').'components/customdatabase/').'model/customdatabase/',$scriptProperties);
if (!($customDb instanceof CustomDatabase)) return 'something went wrong here...';



$tableARR = array(  "cdbProducts",
                    "cdbProductImages"
                ); 
                
                
 //ahv schema classes aanpassen
    $modx->loadClass('transport.modPackageBuilder','',false, true);
    $root = "";
    $sources = array(
        'model' => $root.'core/components/customdatabase/model/',
        'schema_file' => $root.'core/components/customdatabase/model/schema/customdatabase.mysql.schema.xml',
    );
    $manager= $modx->getManager();
    $generator= $manager->getGenerator();
 
    if (!is_dir($sources['model'])) { echo 'Model directory not found!';}
    if (!file_exists($sources['schema_file'])) { echo 'Schema file not found!'; }
    
    $generator->parseSchema($sources['schema_file'],$sources['model']);                
                
                

    
//die();

if(!empty($$tableARR)){
    foreach($$tableARR as $table){
        echo $table.'<br/>';
        $backup = $modx->getIterator($table);
        $backup->rewind();
        if($backup->valid()){
            $recordArr = array();
            foreach($backup as $value) {
            	$recordArr[] = $value->toArray();
        	}//foreach($backup as $value) {
        }//if($backup->valid()){
        
        
        //opslaan in sessie want script moet 2 keer worden uitgevoerd
        //na 1ste keer is het schema aangepast en kunnen de waardes niet meer uit de tabel gehaald worden
        if(!empty($recordArr))$_SESSION[$table]=$recordArr;
            
        
        
        
       
        
    	//echo "ok".$tabel."<br/>";
        $removed = $manager->removeObjectContainer($table);
    	echo $removed ? 'Table '.$table.' removed.' : 'Table '.$table.' NOT REMOVED!';
    	echo "<br/>";
        
    	$created = $manager->createObjectContainer($table);
    	echo $created ? 'Table '.$table.' created.' : 'Table '.$table.' not created.'; 
        echo "<br/><br/>";
        
        //waardes uit sessie terug in array steken en sessie leegmaken
        if(empty($recordArr)){
            $recordArr=$_SESSION[$table];
            $_SESSION[$table]="";
        }//if(empty($recordArr)){
        
        if(!empty($recordArr)){
        	foreach($recordArr as $record) {		
                echo "<pre>";
                print_r($record); 
                echo "</pre><br/>";
        		$object = $modx->newObject($table);
                //$object->save();
        		$object->fromArray($record,'',true);
        		$object->save();
        	}//foreach($recordArr as $record) {		
        }//if(!empty($recordArr)){
    	
    }//foreach($tabelArr as $tabel){

}//if(!empty($tabelArr)){
return $output;