<?php defined('_JEXEC') or die('Restricted access'); 
if(count($this->programs) > 0) {?>
<html>
<head>
<style type="text/stylesheet">
   html, body { bgcolor: white; font-family: opensans; padding: 1em; }
</style>
</head>
<body>
   <?php
   foreach($this->programs as $pid => $program) {
      $rents = $pid != 1006 && $pid != 1005;?>
   <h1>
      <?php echo $program["name"];?>
   </h1>
   <table>
      <thead>
         <tr valign="bottom">
            <td <?php echo $rents ? " rowspan='2'" : "";?>>Last Name</td>
            <td <?php echo $rents ? " rowspan='2'" : "";?>>First Name</td>
            <td <?php echo $rents ? " rowspan='2'" : "";?>>Age</td>
            <?php if($rents) {?>
            <td <?php echo $rents ? " rowspan='2'" : "";?>>Grade</td>
            <td colspan="4" align="center">Parent, Guardian, or Sponsor</td>
         </tr>
         <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Phone Number</td>
            <td>Room Number</td>
            <?php }?>
         </tr>
      </thead>
      <tbody>
         <?php foreach($program["campers"] as $camper) {?>
         <tr>
            <td><?php echo $camper->lastname;?></td>
            <td><?php echo $camper->firstname;?></td>
            <td><?php echo $camper->age;?></td>
            <?php if($rents) {?>
            <td><?php echo $camper->grade?></td>
            <td><?php echo $camper->pfullname;?></td>
            <td><?php echo $camper->pemail;?></td>
            <td nowrap="nowrap"><?php echo substr($camper->pphonenbr, 0, 3);?>-<?php echo substr($camper->pphonenbr, 3, 3);?>-<?php echo substr($camper->pphonenbr, 6);?>
            </td>
            <td><?php echo $camper->proomnbr;?></td>
            <?php }?>
         </tr>
         <?php }?>
      </tbody>
   </table>
   <div style='page-break-after: always; font-size: 1pt;'></div>
   <?php }?>
</body>
</html>
<?php }?>