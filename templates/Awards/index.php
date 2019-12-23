<!-- File: templates/Milestones/index.php -->

<h1>Awards</h1>
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($awards as $award): ?>
        <tr>
            <td>
                <?= $award->name ?>
            </td>
            <td>
                <?= $award->id ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
