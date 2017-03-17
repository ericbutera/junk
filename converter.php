<?php
$input = !empty($_REQUEST['input']) ? $_REQUEST['input'] : false;
$filter = !empty($_REQUEST['filter']) ? $_REQUEST['filter'] : false;
$output = false;

$possibilities = array(
    'serialize' => array('serialize', 'unserialize'),
    'url' => array('urlencode', 'urldecode', 'rawurlencode', 'rawurldecode'),
    'htmlspecialchars' => array('htmlspecialchars', 'htmlspecialchars_decode'),
    'htmlentities' => array('htmlentities', 'html_entity_decode'),
    'slashes' => array('addslashes', 'stripslashes'),
    'quoted_printable' => array('quoted_printable_encode', 'quoted_printable_decode'),
    'hash' => array('md5', 'sha1'),
    'misc' => array('strtoupper', 'strtolower')
);

$filters = array();
foreach ($possibilities as $type => $current) {
    foreach ($current as $_filter) {
        $filters[] = $_filter;
    }
}

if ($filter && in_array($filter, $filters)) {
    $output = call_user_func($filter, $input);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transmuter ⚗</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">

        <h1>Make a thing another</h1>

        <?php if ($input !== false): ?>
            <h3>Output in pre tag</h3>
            <div style="max-height: 250px; overflow: scroll;">
                <pre><?= htmlspecialchars($output) ?></pre>
            </div>

            <h3>var_dump</h3>
            <div style="max-height: 250px; overflow: scroll;">
                <?php var_dump($output) ?>
            </div>
        <?php endif ?>

        <h2>Convert/Filter</h2>
        <form method="post">

            <div class="form-group">
                <label for="filter">Filter</label>
                <select name="filter" id="filter" class="form-control">
                    <?php foreach ($possibilities as $group => $_filters): ?>
                    <optgroup label="<?= htmlspecialchars($group) ?>">
                        <?php foreach ($_filters as $_filter): ?>
                            <option value="<?= htmlspecialchars($_filter) ?>" <?= $filter == $_filter ? ' selected' : '' ?>><?= htmlspecialchars($_filter) ?></option>
                        <?php endforeach ?>
                    </optgroup>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <textarea name="input" class="form-control" style="width:100%; height:250px;" placeholder="raw materials here"><?= htmlspecialchars($input) ?></textarea>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-default" value="transmute ⚗" />
            </div>
        </form>

    </div>
</body>
</html>

