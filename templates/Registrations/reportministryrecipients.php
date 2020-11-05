<h2>Total Recipients by Ministry</h2>
<?php $milestoneNames = array('25 years','30 years','35 years', '45 years', '50 years');?>
<table>
 <thead>
 <tr>
 <th>Ministry</th>
 <?php foreach($milestoneNames as $milestoneName) :?>
 <th><?= $milestoneName?></th>
 <?php endforeach ?>
 </tr>
 </thead>
 
 <tbody>
 
<?php foreach ($ministries as $ministryMilestoneCount) :?>
 <tr>
 <td><?= $ministryMilestoneCount->ministry->name ?></td>
 <?php foreach($milestoneNames as $milestoneName) ?>
 <?php foreach ($ministries as $milestoneCount) :?>
 <?php if ($ministryMilestoneCount->ministry->name == $milestoneCount->ministry->name) :?>
 <?php if ($milestoneCount->milestone->name == $milestoneName):?>
 <td><?= $milestoneCount->count ?></td>
 <?php endif; ?>
 <?php endif; ?>
 <?php endforeach; ?>
 </tr>
<?php endforeach; ?>
 </tbody>
 </table>

        
