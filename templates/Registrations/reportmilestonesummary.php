<h2>Total Recipients by Milestone - <?php echo date("Y"); ?></h2>
<table>
    <tr>
        <th>Milestone</th>
        <th>Count</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($milestones as $milestone): ?>
        <tr>
            <td>
                <?= $milestone->milestone->name ?>
            </td>
            <td>
                <?= $milestone->count ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>


<script>
    var milestones=<?php echo json_encode($milestones); ?>;

    console.log(milestones);
</script>
