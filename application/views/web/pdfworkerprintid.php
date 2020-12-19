<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Id card</title>
	<style>
	   *{box-sizing:border-box;}
	   .main{width:40%;margin:0 auto;border:2px solid #031348;}
	   .half-30{width:30%;float:left;}
	   .half-70{width:70%;float:left;padding:0;}
	   .inner-main{width:100%;float:left;border-bottom:5px solid #031348;padding:10px 0}	   
	   .photo{width:110px;height:110px;border:1px solid #000;float:left;text-align:center;vertical-align:middle;padding-top:5px;}
	   .photo img{width:100%;height:100%;}
	   .half{width:50%;float:left;}
	   .detail{width:100%;float:left;margin:15px 0 10px;padding:0 15px;}
	   .inner-main{background:#f37022}
	   .half-70 h1{margin:0;padding:0;float:left;color:#fff;font-size:20px;}
	   .half-70 p{margin:0;padding:0;float:left;color:#fff;text-transform:capitlize;font-size:13px;}
	   .half-70 table td{padding-bottom:5px}
	</style>

   

</head>

<body>
    <div class="main">
	    <div class="inner-main">	     
		   <div class="half-30"><img src="<?php echo base_url();?>uploads/<?php echo $locationdetail->logo; ?>" width="110">
		   </div>
		   <div class="half-70">
		      <h1 style="margin:50px 0 0 0;padding:0;float:left;"><?php echo $locationdetail->l_name; ?></h1>
			  <p  style="margin:0;padding:0;float:left;"><?php echo $locationdetail->address; ?></p>
		   </div>
		</div>
		<div class="detail">
		   <div class="half-30">		    
		      <div class="photo">
			 <img src="<?php echo base_url();?>uploads/<?php echo $detail->img; ?>"/>
			  </div>
		   </div>
		   <div class="half-70" style="padding:0;">	
		   <table valign="top" style="width:100%;">
		      <tr>
			     <td style="">
				   Name:
				 </td>
			     <td style="border-bottom:1px solid #000;"><?php echo $detail->name; ?></td>
			  </tr>
			  <tr>
			     <td style="">
				   Deler:
				 </td>
			     <td style="border-bottom:1px solid #000;"><?php echo $locationdetail->dealar; ?></td>
			  </tr>
			  <tr>
			     <td style="">
				  Company Phone:
				 </td>
			     <td style="border-bottom:1px solid #000;"><?php echo $locationdetail->phone_no; ?></td>
			  </tr>
		   </table>
		   </div>
		   <pagebreak>
		   <table valign="top" style="width:100%;">
				
		      <tr>
			  <?php foreach($locationwallat as $wallat){ ?>
			     <td style="text-align:center;">
				   <?php echo $wallat->name; ?>
				 </td>
			  <?php } ?>
			  </tr>
			  <tr>
			  <?php foreach($locationwallat as $wallat){ ?>
			     <td style="text-align:center;">
				   <img src="<?php echo base_url();?>uploads/<?php echo $wallat->img; ?>">
				 </td>
			  <?php } ?>
			  </tr>
			  
		   </table>
		   
	   </div>
	</div>
</body>
