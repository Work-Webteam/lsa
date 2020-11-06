<h1>Ministry Summary</h1>

<table>
    <tr>
        <th>Award</th>
        <th>Count</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($registrations as $registration): ?>
        <tr>
            <td>
                <?= $registration->ministry->name ?>
            </td>
            <td>
                <?= $registration->count ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>



