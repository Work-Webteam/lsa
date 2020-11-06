<h1>Milestone Summary</h1>

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

<br><hr><br>

<table>
    <tr>
        <th>Ministry</th>
        <th>Milestone</th>
        <th>Count</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($ministries as $milestone): ?>
        <tr>
            <td>
                <?= $milestone->ministry->name ?>
            </td>
            <td>
                <?= $milestone->milestone->name ?>
            </td>
            <td>
                <?= $milestone->count ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
