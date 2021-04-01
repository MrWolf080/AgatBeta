<form name='frm' action='' method='post' >
<select name='m1' onChange='document.frm.submit();' >
	<option value='<?   if($_POST['m1']!=''){ echo $_POST['m1'];}?>'><?   if($_POST['m1']!=''){ echo $_POST['m1'];}?></option>
  <option value='10'>10</option>
  <option value='20'>20</option>
</select>

<select name='m2' onChange=''>

<?
echo '<option  value= "test">'.print_r($_POST).'</option>';
/*switch($_POST['m1']){
	
	case'':
	break;
	case '10':
		//echo '';
			for($i=0;$i<10;$i++){
				echo '<option  value= '.$i.'>'.$i.'</option>';
			}
	break;
	case '20':
			for($i=0;$i<20;$i++){
			echo '<option  value= '.$i. '>'.$i.'</option>
';
		}

	break;
}		*/
?>
</select>
</form>