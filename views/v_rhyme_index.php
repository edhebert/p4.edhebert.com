<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h1 class="page-header"><?= $word ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-2 centered">
        <h2>Rhymes</h2>
        <p>The rhymes for <?= $word ?> are:
            <ul>
                <?php foreach ($rhymes as $rhyme)
                    echo '<li>' . $rhyme . '</li>';
                ?>
            </ul>
        </p>

    </div>
</div>
